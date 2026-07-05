<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $dateFrom = $request->query('date_from') ?: null;
        $dateTo = $request->query('date_to') ?: null;
        $status = $this->normalizeStatus($request->query('status'));

        $today = today();

        $borrowings = $this->filteredBorrowingsQuery($dateFrom, $dateTo, $status)
            ->with(['user', 'details.product'])
            ->orderByDesc('borrow_date')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $totalProducts = Product::count();

        $availableStock = Product::sum('stock');

        $borrowedQuantity = BorrowingDetail::whereHas('borrowing', function ($query) {
            $query->where('status', 'borrowed');
        })->sum('quantity');

        $totalBorrowings = Borrowing::count();

        $returnedBorrowings = Borrowing::where('status', 'returned')->count();

        $overdueBorrowings = Borrowing::where('status', 'borrowed')
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', $today)
            ->count();

        $lowStockProducts = Product::with('category')
            ->orderBy('stock')
            ->orderBy('name')
            ->limit(5)
            ->get();

        $driver = DB::connection()->getDriverName();

        $monthExpression = match ($driver) {
            'pgsql' => "TO_CHAR(borrow_date, 'MM')",
            'sqlite' => "strftime('%m', borrow_date)",
            default => "LPAD(MONTH(borrow_date), 2, '0')",
        };

        $monthlyQuery = Borrowing::query();

        $this->applyDateFilters($monthlyQuery, $dateFrom, $dateTo);

        if (! $dateFrom && ! $dateTo) {
            $monthlyQuery->whereYear('borrow_date', now()->year);
        }

        $monthlyRaw = $monthlyQuery
            ->selectRaw("$monthExpression as month, COUNT(*) as total")
            ->groupByRaw($monthExpression)
            ->orderByRaw($monthExpression)
            ->pluck('total', 'month');

        $monthlyChartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        $monthlyChartData = collect(range(1, 12))
            ->map(function ($month) use ($monthlyRaw) {
                $key = str_pad((string) $month, 2, '0', STR_PAD_LEFT);

                return (int) ($monthlyRaw[$key] ?? 0);
            })
            ->values();

        $statusBaseQuery = Borrowing::query();

        $this->applyDateFilters($statusBaseQuery, $dateFrom, $dateTo);

        $activeBorrowings = (clone $statusBaseQuery)
            ->where('status', 'borrowed')
            ->where(function ($query) use ($today) {
                $query->whereNull('due_date')
                    ->orWhereDate('due_date', '>=', $today);
            })
            ->count();

        $overdueInPeriod = (clone $statusBaseQuery)
            ->where('status', 'borrowed')
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', $today)
            ->count();

        $returnedInPeriod = (clone $statusBaseQuery)
            ->where('status', 'returned')
            ->count();

        $statusChartLabels = ['Dipinjam', 'Terlambat', 'Dikembalikan'];

        $statusChartData = [
            $activeBorrowings,
            $overdueInPeriod,
            $returnedInPeriod,
        ];

        return view('reports.index', compact(
            'borrowings',
            'dateFrom',
            'dateTo',
            'status',
            'totalProducts',
            'availableStock',
            'borrowedQuantity',
            'totalBorrowings',
            'returnedBorrowings',
            'overdueBorrowings',
            'lowStockProducts',
            'monthlyChartLabels',
            'monthlyChartData',
            'statusChartLabels',
            'statusChartData'
        ));
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $dateFrom = $request->query('date_from') ?: null;
        $dateTo = $request->query('date_to') ?: null;
        $status = $this->normalizeStatus($request->query('status'));

        $borrowings = $this->filteredBorrowingsQuery($dateFrom, $dateTo, $status)
            ->with(['user', 'details.product'])
            ->orderByDesc('borrow_date')
            ->orderByDesc('id')
            ->get();

        $filename = 'laporan-inventra-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($borrowings) {
            $handle = fopen('php://output', 'w');

            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, [
                'No',
                'Peminjam',
                'Barang',
                'Tanggal Pinjam',
                'Batas Kembali',
                'Tanggal Kembali',
                'Status',
            ]);

            foreach ($borrowings as $index => $borrowing) {
                fputcsv($handle, [
                    $index + 1,
                    $borrowing->borrower_name ?? $borrowing->user->name,
                    $borrowing->details->pluck('product.name')->join(', '),
                    $borrowing->borrow_date,
                    $borrowing->due_date ?? '-',
                    $borrowing->return_date ?? '-',
                    $this->statusLabel($borrowing),
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function filteredBorrowingsQuery(?string $dateFrom, ?string $dateTo, ?string $status): Builder
    {
        $today = today();

        $query = Borrowing::query();

        $this->applyDateFilters($query, $dateFrom, $dateTo);

        return $query->when($status, function ($query) use ($status, $today) {
            if ($status === 'borrowed') {
                $query->where('status', 'borrowed')
                    ->where(function ($query) use ($today) {
                        $query->whereNull('due_date')
                            ->orWhereDate('due_date', '>=', $today);
                    });
            }

            if ($status === 'overdue') {
                $query->where('status', 'borrowed')
                    ->whereNotNull('due_date')
                    ->whereDate('due_date', '<', $today);
            }

            if ($status === 'returned') {
                $query->where('status', 'returned');
            }
        });
    }

    private function applyDateFilters(Builder $query, ?string $dateFrom, ?string $dateTo): void
    {
        $query
            ->when($dateFrom, function ($query) use ($dateFrom) {
                $query->whereDate('borrow_date', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                $query->whereDate('borrow_date', '<=', $dateTo);
            });
    }

    private function normalizeStatus(?string $status): ?string
    {
        return in_array($status, ['borrowed', 'overdue', 'returned'], true)
            ? $status
            : null;
    }

    private function statusLabel(Borrowing $borrowing): string
    {
        if ($borrowing->status === 'borrowed' && $borrowing->isOverdue()) {
            return 'Terlambat';
        }

        if ($borrowing->status === 'borrowed') {
            return 'Dipinjam';
        }

        if ($borrowing->status === 'returned') {
            return 'Dikembalikan';
        }

        return ucfirst($borrowing->status);
    }
}
