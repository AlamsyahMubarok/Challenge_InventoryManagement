<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Product;
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

        $monthlyBorrowings = Borrowing::selectRaw("strftime('%m', borrow_date) as month, COUNT(*) as total")
            ->whereYear('borrow_date', now()->year)
            ->groupBy('month')
            ->orderBy('month')
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
            'monthlyChartLabels',
            'monthlyChartData',
            'latestBorrowings'
        ));
    }
}
