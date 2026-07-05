<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalProductTypes = Product::count();

        $availableStock = Product::sum('stock');

        $borrowedQuantity = BorrowingDetail::whereHas('borrowing', function ($query) {
            $query->where('status', 'borrowed');
        })->sum('quantity');

        $returnedBorrowings = Borrowing::where('status', 'returned')->count();

        $lowStockCount = Product::whereColumn('stock', '<=', 'minimum_stock')
            ->count();

        $lowStockProducts = Product::with('category')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')
            ->orderBy('name')
            ->limit(6)
            ->get();

        $driver = DB::connection()->getDriverName();

        $monthExpression = match ($driver) {
            'pgsql' => "TO_CHAR(borrow_date, 'MM')",
            'sqlite' => "strftime('%m', borrow_date)",
            default => "LPAD(MONTH(borrow_date), 2, '0')",
        };

        $monthlyBorrowings = Borrowing::selectRaw("$monthExpression as month, COUNT(*) as total")
            ->whereYear('borrow_date', now()->year)
            ->groupByRaw($monthExpression)
            ->orderByRaw($monthExpression)
            ->pluck('total', 'month');

        $months = collect(range(1, 12))->map(function ($month) {
            return str_pad((string) $month, 2, '0', STR_PAD_LEFT);
        });

        $monthlyChartLabels = $months->map(function ($month) {
            return date('M', mktime(0, 0, 0, (int) $month, 1));
        });

        $monthlyChartData = $months->map(function ($month) use ($monthlyBorrowings) {
            return $monthlyBorrowings[$month] ?? 0;
        });

        $latestBorrowings = Borrowing::with(['user', 'details.product'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalProductTypes',
            'availableStock',
            'borrowedQuantity',
            'returnedBorrowings',
            'lowStockCount',
            'lowStockProducts',
            'monthlyChartLabels',
            'monthlyChartData',
            'latestBorrowings'
        ));
    }
}
