<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
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

        $totalProducts = Product::count();

        $lowStockProductsCount = Product::whereColumn('stock', '<=', 'minimum_stock')
            ->count();

        return view('products.index', compact(
            'products',
            'search',
            'stockStatus',
            'totalProducts',
            'lowStockProductsCount'
        ));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
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

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('popup_success', [
                'title' => 'Barang Berhasil Ditambahkan',
                'icon' => asset('images/barang.png'),
            ]);
    }

    public function show(Product $product): View
    {
        $product->load('category');

        $product->loadSum([
            'borrowingDetails as borrowed_quantity' => function ($query) {
                $query->whereHas('borrowing', function ($query) {
                    $query->where('status', 'borrowed');
                });
            },
        ], 'quantity');

        return view('products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
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

        return redirect()
            ->route('products.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->borrowingDetails()->exists()) {
            return redirect()
                ->route('products.index')
                ->with('error', 'Barang tidak bisa dihapus karena sudah pernah digunakan dalam peminjaman.');
        }

        if ($product->image) {
            Storage::disk('supabase')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Barang berhasil dihapus.');
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
