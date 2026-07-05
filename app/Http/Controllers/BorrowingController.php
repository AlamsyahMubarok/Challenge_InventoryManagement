<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $borrowings = Borrowing::with(['user', 'details.product'])
            ->when($search, function ($query) use ($search) {
                $search = strtolower($search);

                $query->where(function ($query) use ($search) {
                    $query->whereRaw('LOWER(COALESCE(borrower_name, \'\')) LIKE ?', ["%{$search}%"])
                        ->orWhereRaw('LOWER(status) LIKE ?', ["%{$search}%"])
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
                        })
                        ->orWhereHas('details.product', function ($query) use ($search) {
                            $query->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                                ->orWhereRaw('LOWER(code) LIKE ?', ["%{$search}%"]);
                        });

                    if (str_contains($search, 'dipinjam')) {
                        $query->orWhere('status', 'borrowed');
                    }

                    if (str_contains($search, 'dikembalikan') || str_contains($search, 'kembali')) {
                        $query->orWhere('status', 'returned');
                    }

                    if (str_contains($search, 'terlambat')) {
                        $query->orWhere(function ($query) {
                            $query->where('status', 'borrowed')
                                ->whereDate('due_date', '<', today());
                        });
                    }
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('borrowings.index', compact('borrowings', 'search'));
    }

    public function create(): View
    {
        $products = Product::with('category')
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        return view('borrowings.create', compact('products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'borrower_name' => ['nullable', 'string', 'max:255'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'borrow_date' => ['required', 'date'],
            'due_date' => ['nullable', 'date', 'after_or_equal:borrow_date'],
            'notes' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated, $request) {
            $product = Product::whereKey($validated['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($product->stock < $validated['quantity']) {
                throw ValidationException::withMessages([
                    'quantity' => 'Stok tidak mencukupi. Stok tersedia: '.$product->stock,
                ]);
            }

            $borrowing = Borrowing::create([
                'user_id' => $request->user()->id,
                'borrower_name' => $validated['borrower_name'],
                'borrow_date' => $validated['borrow_date'],
                'due_date' => $validated['due_date'] ?? null,
                'status' => 'borrowed',
                'notes' => $validated['notes'] ?? null,
            ]);

            $borrowing->details()->create([
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
                'condition_before' => $product->condition,
            ]);

            $product->decrement('stock', $validated['quantity']);
        });

        return redirect()
            ->route('borrowings.index')
            ->with('popup_success', [
                'title' => 'Peminjaman Berhasil Ditambahkan',
                'icon' => asset('images/peminjaman.png'),
            ]);
    }

    public function show(Borrowing $borrowing): View
    {
        $borrowing->load(['user', 'details.product.category']);

        return view('borrowings.show', compact('borrowing'));
    }

    public function returnItem(Request $request, Borrowing $borrowing): RedirectResponse
    {
        $validated = $request->validate([
            'condition_after' => ['nullable', 'string', 'max:50'],
            'return_notes' => ['nullable', 'string'],
        ]);

        if ($borrowing->status === 'returned') {
            return redirect()
                ->route('borrowings.show', $borrowing)
                ->with('error', 'Barang sudah dikembalikan sebelumnya.');
        }

        DB::transaction(function () use ($borrowing, $validated) {
            $borrowing = Borrowing::whereKey($borrowing->id)
                ->lockForUpdate()
                ->firstOrFail();

            $borrowing->load('details');

            foreach ($borrowing->details as $detail) {
                $product = Product::whereKey($detail->product_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $conditionAfter = $validated['condition_after'] ?? 'Baik';

                if ($conditionAfter === 'Rusak Ringan') {
                    $product->increment('light_damage_stock', $detail->quantity);
                } elseif ($conditionAfter === 'Rusak Berat') {
                    $product->increment('heavy_damage_stock', $detail->quantity);
                } elseif ($conditionAfter === 'Maintenance') {
                    $product->increment('maintenance_stock', $detail->quantity);
                } else {
                    $product->increment('stock', $detail->quantity);
                }

                $detail->update([
                    'condition_after' => $conditionAfter,
                    'notes' => $validated['return_notes'] ?? null,
                ]);
            }

            $borrowing->update([
                'status' => 'returned',
                'return_date' => now()->toDateString(),
            ]);
        });

        return redirect()
            ->route('borrowings.index')
            ->with('success', 'Barang berhasil dikembalikan.');
    }
}
