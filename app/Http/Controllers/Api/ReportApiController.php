<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['nullable', 'string', 'in:borrowed,returned'],
        ]);

        $startDate = $validated['start_date'] ?? null;
        $endDate = $validated['end_date'] ?? null;
        $status = $validated['status'] ?? null;

        $borrowingsQuery = Borrowing::query()
            ->when($startDate, function ($query) use ($startDate) {
                $query->whereDate('borrow_date', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->whereDate('borrow_date', '<=', $endDate);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            });

        $totalBorrowings = (clone $borrowingsQuery)->count();

        $activeBorrowings = (clone $borrowingsQuery)
            ->where('status', 'borrowed')
            ->count();

        $returnedBorrowings = (clone $borrowingsQuery)
            ->where('status', 'returned')
            ->count();

        $borrowedQuantity = BorrowingDetail::whereHas('borrowing', function ($query) use ($startDate, $endDate, $status) {
            $query
                ->when($startDate, function ($query) use ($startDate) {
                    $query->whereDate('borrow_date', '>=', $startDate);
                })
                ->when($endDate, function ($query) use ($endDate) {
                    $query->whereDate('borrow_date', '<=', $endDate);
                })
                ->when($status, function ($query) use ($status) {
                    $query->where('status', $status);
                });
        })->sum('quantity');

        $statusDistribution = (clone $borrowingsQuery)
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->orderBy('status')
            ->pluck('total', 'status');

        $driver = DB::connection()->getDriverName();

        $monthExpression = match ($driver) {
            'pgsql' => "TO_CHAR(borrow_date, 'YYYY-MM')",
            'sqlite' => "strftime('%Y-%m', borrow_date)",
            default => "DATE_FORMAT(borrow_date, '%Y-%m')",
        };

        $monthlyBorrowings = (clone $borrowingsQuery)
            ->selectRaw("$monthExpression as month, COUNT(*) as total")
            ->groupByRaw($monthExpression)
            ->orderByRaw($monthExpression)
            ->get();

        $topBorrowedProducts = BorrowingDetail::select(
                'product_id',
                DB::raw('SUM(quantity) as total_borrowed')
            )
            ->whereHas('borrowing', function ($query) use ($startDate, $endDate, $status) {
                $query
                    ->when($startDate, function ($query) use ($startDate) {
                        $query->whereDate('borrow_date', '>=', $startDate);
                    })
                    ->when($endDate, function ($query) use ($endDate) {
                        $query->whereDate('borrow_date', '<=', $endDate);
                    })
                    ->when($status, function ($query) use ($status) {
                        $query->where('status', $status);
                    });
            })
            ->with('product.category')
            ->groupBy('product_id')
            ->orderByDesc('total_borrowed')
            ->limit(10)
            ->get();

        $lowStockProducts = Product::with('category')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')
            ->orderBy('name')
            ->limit(10)
            ->get();

        $inventorySummary = [
            'total_product_types' => Product::count(),
            'ready_stock' => Product::sum('stock'),
            'light_damage_stock' => Product::sum('light_damage_stock'),
            'heavy_damage_stock' => Product::sum('heavy_damage_stock'),
            'maintenance_stock' => Product::sum('maintenance_stock'),
            'low_stock_count' => Product::whereColumn('stock', '<=', 'minimum_stock')->count(),
        ];

        return response()->json([
            'message' => 'Data laporan berhasil diambil.',
            'filters' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => $status,
            ],
            'data' => [
                'summary' => [
                    'total_borrowings' => $totalBorrowings,
                    'active_borrowings' => $activeBorrowings,
                    'returned_borrowings' => $returnedBorrowings,
                    'borrowed_quantity' => $borrowedQuantity,
                ],
                'inventory_summary' => $inventorySummary,
                'status_distribution' => $statusDistribution,
                'monthly_borrowings' => $monthlyBorrowings,
                'top_borrowed_products' => $topBorrowedProducts,
                'low_stock_products' => $lowStockProducts,
            ],
        ]);
    }
}
