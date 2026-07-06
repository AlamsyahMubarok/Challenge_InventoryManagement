<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $categories = Category::withCount('products')
            ->when($search, function ($query) use ($search) {
                $search = strtolower($search);

                $query->where(function ($query) use ($search) {
                    $query->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                        ->orWhereRaw('LOWER(description) LIKE ?', ["%{$search}%"]);
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('categories.index', compact('categories', 'search'));
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
        ]);

        Category::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Request $request, Category $category): View
    {
        $search = $request->query('search');

        $products = $category->products()
            ->with('category')
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
                        ->orWhere('condition', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalProducts = $category->products()->count();

        $availableStock = $category->products()->sum('stock');

        $lowStockProductsCount = $category->products()
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->count();

        return view('categories.show', compact(
            'category',
            'products',
            'search',
            'totalProducts',
            'availableStock',
            'lowStockProductsCount'
        ));
    }

    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
        ]);

        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return redirect()
                ->route('categories.index')
                ->with('error', 'Kategori tidak bisa dihapus karena masih memiliki barang.');
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
