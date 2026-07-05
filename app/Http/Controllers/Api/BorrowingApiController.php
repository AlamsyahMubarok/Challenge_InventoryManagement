<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowingApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $borrowings = Borrowing::with(['user.role', 'details.product.category'])
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('borrower_name', 'like', "%{$search}%")
                        ->orWhere('borrow_date', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        })
                        ->orWhereHas('details.product', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhere('code', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return response()->json([
            'message' => 'Data peminjaman berhasil diambil.',
            'data' => $borrowings,
        ]);
    }

    public function show(Borrowing $borrowing): JsonResponse
    {
        $borrowing->load(['user.role', 'details.product.category']);

        return response()->json([
            'message' => 'Detail peminjaman berhasil diambil.',
            'data' => $borrowing,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'borrower_name' => ['nullable', 'string', 'max:255'],
            'borrow_date' => ['required', 'date'],
            'return_date' => ['nullable', 'date', 'after_or_equal:borrow_date'],
            'notes' => ['nullable', 'string'],

            'details' => ['required', 'array', 'min:1'],
            'details.*.product_id' => ['required', 'exists:products,id'],
            'details.*.quantity' => ['required', 'integer', 'min:1'],
            'details.*.notes' => ['nullable', 'string'],
        ]);

        $borrowing = DB::transaction(function () use ($request, $validated) {
            $borrowing = Borrowing::create([
                'user_id' => $request->user()->id,
                'borrower_name' => $validated['borrower_name'] ?? $request->user()->name,
                'borrow_date' => $validated['borrow_date'],
                'return_date' => $validated['return_date'] ?? null,
                'status' => 'borrowed',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['details'] as $item) {
                $product = Product::whereKey($item['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                $quantity = (int) $item['quantity'];

                if ($product->stock < $quantity) {
                    abort(response()->json([
                        'message' => "Stok barang {$product->name} tidak mencukupi.",
                        'errors' => [
                            'stock' => [
                                "Stok tersedia hanya {$product->stock}.",
                            ],
                        ],
                    ], 422));
                }

                $product->decrement('stock', $quantity);

                $borrowing->details()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'condition_before' => $product->condition,
                    'condition_after' => null,
                    'notes' => $item['notes'] ?? null,
                ]);
            }

            return $borrowing;
        });

        $borrowing->load(['user.role', 'details.product.category']);

        return response()->json([
            'message' => 'Peminjaman berhasil dibuat.',
            'data' => $borrowing,
        ], 201);
    }

    public function returnItem(Request $request, Borrowing $borrowing): JsonResponse
    {
        $validated = $request->validate([
            'condition_after' => ['required', 'string', 'in:Baik,Rusak Ringan,Rusak Berat,Maintenance'],
            'return_notes' => ['nullable', 'string'],
        ]);

        if ($borrowing->status === 'returned') {
            return response()->json([
                'message' => 'Peminjaman ini sudah dikembalikan.',
            ], 422);
        }

        DB::transaction(function () use ($borrowing, $validated) {
            $borrowing = Borrowing::whereKey($borrowing->id)
                ->lockForUpdate()
                ->with('details')
                ->firstOrFail();

            foreach ($borrowing->details as $detail) {
                $product = Product::whereKey($detail->product_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $conditionAfter = $validated['condition_after'];

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
                    'notes' => $validated['return_notes'] ?? $detail->notes,
                ]);
            }

            $borrowing->update([
                'status' => 'returned',
            ]);
        });

        $borrowing->refresh();
        $borrowing->load(['user.role', 'details.product.category']);

        return response()->json([
            'message' => 'Barang berhasil dikembalikan.',
            'data' => $borrowing,
        ]);
    }
}
