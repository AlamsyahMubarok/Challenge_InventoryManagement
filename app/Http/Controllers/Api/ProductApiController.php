<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = $request->query('search');
        $stockStatus = $request->query('stock_status');

        if (! in_array($stockStatus, ['low_stock'], true)) {
            $stockStatus = null;
        }

        $products = Product::with('category')
            ->withSum([
                'borrowingDetails as borrowed_quantity' => function ($query) {
                    $query->whereHas('borrowing', function ($query) {
                        $query->where('status', 'borrowed');
                    });
                },
            ], 'quantity')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhere('condition', 'like', "%{$search}%")
                        ->orWhereHas('category', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($stockStatus === 'low_stock', function ($query) {
                $query->whereColumn('stock', '<=', 'minimum_stock');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return response()->json([
            'message' => 'Data barang berhasil diambil.',
            'data' => $products,
        ]);
    }

    public function show(Product $product): JsonResponse
    {
        $product->load('category');

        $product->loadSum([
            'borrowingDetails as borrowed_quantity' => function ($query) {
                $query->whereHas('borrowing', function ($query) {
                    $query->where('status', 'borrowed');
                });
            },
        ], 'quantity');

        return response()->json([
            'message' => 'Detail barang berhasil diambil.',
            'data' => $product,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'code' => ['required', 'string', 'max:50', 'unique:products,code'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'light_damage_stock' => ['required', 'integer', 'min:0'],
            'heavy_damage_stock' => ['required', 'integer', 'min:0'],
            'maintenance_stock' => ['required', 'integer', 'min:0'],
            'location' => ['required', 'string', 'max:255'],
            'condition' => ['required', 'string', 'max:50'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadProductImage($request);
        }

        $product = Product::create($validated);

        $product->load('category');

        return response()->json([
            'message' => 'Barang berhasil ditambahkan.',
            'data' => $product,
        ], 201);
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('products', 'code')->ignore($product->id),
            ],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'light_damage_stock' => ['required', 'integer', 'min:0'],
            'heavy_damage_stock' => ['required', 'integer', 'min:0'],
            'maintenance_stock' => ['required', 'integer', 'min:0'],
            'location' => ['required', 'string', 'max:255'],
            'condition' => ['required', 'string', 'max:50'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('supabase')->delete($product->image);
            }

            $validated['image'] = $this->uploadProductImage($request);
        }

        $product->update($validated);

        $product->load('category');

        return response()->json([
            'message' => 'Barang berhasil diperbarui.',
            'data' => $product,
        ]);
    }

    public function destroy(Product $product): JsonResponse
    {
        if ($product->borrowingDetails()->exists()) {
            return response()->json([
                'message' => 'Barang tidak bisa dihapus karena sudah pernah digunakan dalam peminjaman.',
            ], 422);
        }

        if ($product->image) {
            Storage::disk('supabase')->delete($product->image);
        }

        $product->delete();

        return response()->json([
            'message' => 'Barang berhasil dihapus.',
        ]);
    }

    private function uploadProductImage(Request $request): string
    {
        $file = $request->file('image');

        $filename = Str::uuid().'.'.$file->getClientOriginalExtension();

        return Storage::disk('supabase')->putFileAs(
            'products',
            $file,
            $filename
        );
    }
}
