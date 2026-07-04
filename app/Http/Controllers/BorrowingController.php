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
                $query->where('borrower_name', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('details.product', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('code', 'like', "%{$search}%");
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
            ->with('success', 'Peminjaman berhasil dibuat.');
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

                $product->increment('stock', $detail->quantity);

                $detail->update([
                    'condition_after' => $validated['condition_after'] ?? null,
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
