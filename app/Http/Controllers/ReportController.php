<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');
        $status = $request->query('status');

        $borrowings = Borrowing::with(['user', 'details.product'])
            ->when($dateFrom, function ($query) use ($dateFrom) {
                $query->whereDate('borrow_date', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                $query->whereDate('borrow_date', '<=', $dateTo);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalProducts = Product::count();

        $availableStock = Product::sum('stock');

        $borrowedQuantity = BorrowingDetail::whereHas('borrowing', function ($query) {
            $query->where('status', 'borrowed');
        })->sum('quantity');

        $totalBorrowings = Borrowing::count();

        $returnedBorrowings = Borrowing::where('status', 'returned')->count();

        return view('reports.index', compact(
            'borrowings',
            'dateFrom',
            'dateTo',
            'status',
            'totalProducts',
            'availableStock',
            'borrowedQuantity',
            'totalBorrowings',
            'returnedBorrowings'
        ));
    }
}
