<x-app-layout>
    @php
        $statusBadge = function ($borrowing) {
            $isOverdue = $borrowing->status === 'borrowed' && $borrowing->isOverdue();

            return match (true) {
                $isOverdue => [
                    'label' => 'Terlambat',
                    'class' => 'bg-red-50 text-red-600 border border-red-100',
                ],
                $borrowing->status === 'borrowed' => [
                    'label' => 'Dipinjam',
                    'class' => 'bg-yellow-50 text-yellow-700 border border-yellow-100',
                ],
                $borrowing->status === 'returned' => [
                    'label' => 'Dikembalikan',
                    'class' => 'bg-green-50 text-green-600 border border-green-100',
                ],
                default => [
                    'label' => ucfirst($borrowing->status),
                    'class' => 'bg-slate-100 text-slate-600 border border-slate-200',
                ],
            };
        };

        $summaryCards = [
            [
                'label' => 'Jenis Barang',
                'value' => $totalProducts,
                'valueClass' => 'text-slate-900',
            ],
            [
                'label' => 'Stok Tersedia',
                'value' => $availableStock,
                'valueClass' => 'text-slate-900',
            ],
            [
                'label' => 'Barang Dipinjam',
                'value' => $borrowedQuantity,
                'valueClass' => 'text-slate-900',
            ],
            [
                'label' => 'Total Peminjaman',
                'value' => $totalBorrowings,
                'valueClass' => 'text-slate-900',
            ],
            [
                'label' => 'Terlambat',
                'value' => $overdueBorrowings,
                'valueClass' => 'text-red-600',
            ],
            [
                'label' => 'Selesai',
                'value' => $returnedBorrowings,
                'valueClass' => 'text-slate-900',
            ],
        ];
    @endphp

    <div class="space-y-6">

        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-bold text-red-500 mb-2">
                    Laporan Inventaris
                </p>

                <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Laporan
                </h1>

                <p class="mt-2 text-slate-500">
                    Pantau kondisi stok, peminjaman, keterlambatan, dan pengembalian barang.
                </p>
            </div>

            <div x-data="{ open: false }" class="relative no-print">
                <button type="button"
                        @click="open = ! open"
                        class="inventra-report-action inline-flex items-center justify-center px-5 py-3 rounded-2xl bg-slate-900 text-white text-sm font-bold shadow-sm hover:bg-slate-800 transition">
                    Cetak Laporan
                </button>

                <div x-show="open"
                     x-transition
                     @click.outside="open = false"
                     style="display: none;"
                     class="inventra-report-dropdown absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden z-30">
                    <button type="button"
                            onclick="window.print()"
                            class="inventra-report-dropdown-item w-full text-left px-5 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50 transition">
                        Cetak sebagai PDF
                    </button>

                    <a href="{{ route('reports.export.csv', request()->query()) }}"
                       class="inventra-report-dropdown-item block px-5 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50 transition">
                        Cetak sebagai CSV
                    </a>
                </div>
            </div>
        </div>

        <div class="rounded-3xl bg-gradient-to-br from-red-500 via-orange-500 to-yellow-400 p-6 lg:p-8 text-white shadow-sm overflow-hidden">
            <div class="max-w-3xl">
                <p class="text-white/80 text-sm font-bold">
                    Inventra Report
                </p>

                <h2 class="mt-3 text-3xl lg:text-4xl font-extrabold leading-tight">
                    Analisis inventaris dan peminjaman dalam satu halaman.
                </h2>

                <p class="mt-4 text-sm lg:text-base leading-7 text-white/85">
                    Gunakan filter tanggal dan status untuk melihat data peminjaman sesuai periode laporan yang dibutuhkan.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-6 gap-5">
            @foreach ($summaryCards as $card)
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                    <p class="text-sm font-extrabold text-slate-500 leading-tight">
                        {{ $card['label'] }}
                    </p>

                    <h3 class="mt-3 text-3xl font-extrabold {{ $card['valueClass'] }}">
                        {{ $card['value'] }}
                    </h3>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900">
                            Grafik Peminjaman Bulanan
                        </h3>

                        <p class="text-sm text-slate-400 mt-1">
                            Jumlah peminjaman berdasarkan bulan.
                        </p>
                    </div>
                </div>

                <div class="h-[300px]">
                    <canvas id="monthlyBorrowingChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                <div class="mb-6">
                    <h3 class="text-xl font-extrabold text-slate-900">
                        Distribusi Status
                    </h3>

                    <p class="text-sm text-slate-400 mt-1">
                        Komposisi status peminjaman.
                    </p>
                </div>

                <div class="h-[240px]">
                    <canvas id="statusDistributionChart"></canvas>
                </div>

                <div class="inventra-report-soft-card mt-5 rounded-2xl bg-slate-50 border border-slate-100 p-4 space-y-3">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-start gap-2">
                            <span class="mt-1.5 h-2.5 w-2.5 rounded-full shrink-0"
                                  style="background-color: rgba(250, 204, 21, 0.72);"></span>

                            <div>
                                <p class="text-xs font-extrabold text-slate-700">
                                    Dipinjam
                                </p>

                                <p class="text-[11px] leading-5 text-slate-400">
                                    Barang masih dalam masa peminjaman.
                                </p>
                            </div>
                        </div>

                        <span class="text-xs font-extrabold text-slate-900">
                            {{ $statusChartData[0] }}
                        </span>
                    </div>

                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-start gap-2">
                            <span class="mt-1.5 h-2.5 w-2.5 rounded-full shrink-0"
                                  style="background-color: rgba(255, 44, 44, 0.72);"></span>

                            <div>
                                <p class="text-xs font-extrabold text-slate-700">
                                    Terlambat
                                </p>

                                <p class="text-[11px] leading-5 text-slate-400">
                                    Barang melewati batas pengembalian.
                                </p>
                            </div>
                        </div>

                        <span class="text-xs font-extrabold text-red-600">
                            {{ $statusChartData[1] }}
                        </span>
                    </div>

                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-start gap-2">
                            <span class="mt-1.5 h-2.5 w-2.5 rounded-full shrink-0"
                                  style="background-color: rgba(34, 197, 94, 0.72);"></span>

                            <div>
                                <p class="text-xs font-extrabold text-slate-700">
                                    Dikembalikan
                                </p>

                                <p class="text-[11px] leading-5 text-slate-400">
                                    Barang sudah selesai dikembalikan.
                                </p>
                            </div>
                        </div>

                        <span class="text-xs font-extrabold text-slate-900">
                            {{ $statusChartData[2] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-900">
                        Barang Stok Menipis
                    </h3>

                    <p class="text-sm text-slate-400 mt-1">
                        Lima barang dengan stok terendah di sistem.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                @forelse ($lowStockProducts as $product)
                    <div class="inventra-report-soft-card rounded-3xl bg-slate-50 border border-slate-100 p-5">
                        <p class="text-sm font-extrabold text-slate-900 leading-tight">
                            {{ $product->name }}
                        </p>

                        <p class="mt-2 text-xs font-bold text-sky-600">
                            {{ $product->category->name ?? '-' }}
                        </p>

                        <p class="mt-4 text-2xl font-extrabold text-red-600">
                            {{ $product->stock }}
                        </p>

                        <p class="mt-1 text-xs font-bold text-slate-400">
                            stok tersisa
                        </p>
                    </div>
                @empty
                    <div class="inventra-report-soft-card md:col-span-5 rounded-3xl bg-slate-50 border border-slate-100 p-5 text-center text-slate-400 text-sm">
                        Belum ada data barang.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 no-print">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-900">
                        Filter Laporan
                    </h3>

                    <p class="text-sm text-slate-400 mt-1">
                        Sesuaikan periode dan status untuk menampilkan laporan tertentu.
                    </p>
                </div>
            </div>

            <form method="GET" action="{{ route('reports.index') }}" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Dari Tanggal
                    </label>

                    <input type="date"
                           name="date_from"
                           value="{{ $dateFrom }}"
                           class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Sampai Tanggal
                    </label>

                    <input type="date"
                           name="date_to"
                           value="{{ $dateTo }}"
                           class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Status
                    </label>

                    <select name="status"
                            class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]">
                        <option value="">Semua Status</option>
                        <option value="borrowed" @selected($status === 'borrowed')>Dipinjam</option>
                        <option value="overdue" @selected($status === 'overdue')>Terlambat</option>
                        <option value="returned" @selected($status === 'returned')>Dikembalikan</option>
                    </select>
                </div>

                <div class="xl:col-span-2 flex items-end gap-3">
                    <button type="submit"
                            class="h-12 px-5 rounded-2xl bg-slate-900 text-white text-sm font-bold hover:bg-slate-800 transition">
                        Filter
                    </button>

                    <a href="{{ route('reports.index') }}"
                       class="h-12 px-5 rounded-2xl bg-slate-100 text-slate-700 text-sm font-bold hover:bg-slate-200 transition inline-flex items-center justify-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-900">
                        Data Laporan
                    </h3>

                    <p class="text-sm text-slate-400 mt-1">
                        Daftar peminjaman berdasarkan filter yang dipilih.
                    </p>
                </div>

                <div class="inventra-report-data-badge hidden sm:block px-4 py-2 rounded-2xl bg-red-50 text-red-600 text-sm font-bold border border-red-100">
                    {{ $borrowings->total() }} Data
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="inventra-report-table min-w-[1120px] w-full">
                    <thead>
                        <tr class="inventra-report-table-head bg-slate-50">
                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500 rounded-l-2xl">No</th>
                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500">Peminjam</th>
                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500">Barang</th>
                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500">Tanggal Pinjam</th>
                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500">Batas Kembali</th>
                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500">Tanggal Kembali</th>
                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500 rounded-r-2xl">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($borrowings as $borrowing)
                            @php
                                $badge = $statusBadge($borrowing);
                            @endphp

                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="px-5 py-4 text-sm text-slate-500">
                                    {{ $borrowings->firstItem() + $loop->index }}
                                </td>

                                <td class="px-5 py-4 text-sm font-bold text-slate-800">
                                    {{ $borrowing->borrower_name ?? $borrowing->user->name }}
                                </td>

                                <td class="px-5 py-4 text-sm text-slate-600">
                                    {{ $borrowing->details->pluck('product.name')->join(', ') }}
                                </td>

                                <td class="px-5 py-4 text-sm text-slate-500 whitespace-nowrap">
                                    {{ $borrowing->borrow_date }}
                                </td>

                                <td class="px-5 py-4 text-sm text-slate-500 whitespace-nowrap">
                                    {{ $borrowing->due_date ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-sm text-slate-500 whitespace-nowrap">
                                    {{ $borrowing->return_date ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-sm">
                                    <span class="inline-flex items-center justify-center whitespace-nowrap px-3 py-1.5 rounded-full text-xs font-bold {{ $badge['class'] }}">
                                        {{ $badge['label'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-10 text-center text-slate-400">
                                    Tidak ada data laporan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($borrowings->hasPages())
                @php
                    $currentPage = $borrowings->currentPage();
                    $lastPage = $borrowings->lastPage();
                    $startPage = max(1, $currentPage - 2);
                    $endPage = min($lastPage, $currentPage + 2);
                @endphp

                <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between no-print">
                    <p class="text-sm text-slate-500">
                        Menampilkan
                        <span class="font-bold text-slate-700">{{ $borrowings->firstItem() }}</span>
                        sampai
                        <span class="font-bold text-slate-700">{{ $borrowings->lastItem() }}</span>
                        dari
                        <span class="font-bold text-slate-700">{{ $borrowings->total() }}</span>
                        data
                    </p>

                    <div class="flex items-center gap-2">
                        @if ($borrowings->onFirstPage())
                            <span class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-300 flex items-center justify-center cursor-not-allowed">
                                ‹
                            </span>
                        @else
                            <a href="{{ $borrowings->previousPageUrl() }}"
                               class="w-10 h-10 rounded-2xl bg-white border border-slate-200 text-slate-600 flex items-center justify-center hover:bg-red-50 hover:text-red-600 hover:border-red-100 transition">
                                ‹
                            </a>
                        @endif

                        @if ($startPage > 1)
                            <a href="{{ $borrowings->url(1) }}"
                               class="w-10 h-10 rounded-2xl bg-white border border-slate-200 text-slate-600 text-sm font-bold flex items-center justify-center hover:bg-red-50 hover:text-red-600 hover:border-red-100 transition">
                                1
                            </a>

                            @if ($startPage > 2)
                                <span class="w-10 h-10 rounded-2xl text-slate-400 flex items-center justify-center">
                                    ...
                                </span>
                            @endif
                        @endif

                        @for ($page = $startPage; $page <= $endPage; $page++)
                            @if ($page === $currentPage)
                                <span class="w-10 h-10 rounded-2xl bg-[#FF2C2C] text-white text-sm font-bold flex items-center justify-center shadow-sm">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $borrowings->url($page) }}"
                                   class="w-10 h-10 rounded-2xl bg-white border border-slate-200 text-slate-600 text-sm font-bold flex items-center justify-center hover:bg-red-50 hover:text-red-600 hover:border-red-100 transition">
                                    {{ $page }}
                                </a>
                            @endif
                        @endfor

                        @if ($endPage < $lastPage)
                            @if ($endPage < $lastPage - 1)
                                <span class="w-10 h-10 rounded-2xl text-slate-400 flex items-center justify-center">
                                    ...
                                </span>
                            @endif

                            <a href="{{ $borrowings->url($lastPage) }}"
                               class="w-10 h-10 rounded-2xl bg-white border border-slate-200 text-slate-600 text-sm font-bold flex items-center justify-center hover:bg-red-50 hover:text-red-600 hover:border-red-100 transition">
                                {{ $lastPage }}
                            </a>
                        @endif

                        @if ($borrowings->hasMorePages())
                            <a href="{{ $borrowings->nextPageUrl() }}"
                               class="w-10 h-10 rounded-2xl bg-white border border-slate-200 text-slate-600 flex items-center justify-center hover:bg-red-50 hover:text-red-600 hover:border-red-100 transition">
                                ›
                            </a>
                        @else
                            <span class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-300 flex items-center justify-center cursor-not-allowed">
                                ›
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const monthlyCtx = document.getElementById('monthlyBorrowingChart');
        const statusCtx = document.getElementById('statusDistributionChart');

        let monthlyBorrowingChart = null;
        let statusDistributionChart = null;

        function isInventraDarkMode() {
            return document.documentElement.classList.contains('dark');
        }

        function getReportChartTheme() {
            const isDark = isInventraDarkMode();

            return {
                tickColor: isDark ? '#cbd5e1' : '#94a3b8',
                gridColor: isDark ? 'rgba(148, 163, 184, 0.28)' : '#f1f5f9',
                tooltipBg: isDark ? '#020617' : '#0f172a',
                tooltipText: '#ffffff',
                barBorder: isDark ? 'rgba(255, 44, 44, 0.55)' : 'rgba(255, 44, 44, 0.35)',
                doughnutBorder: isDark ? '#0f172a' : '#ffffff',
                doughnutColors: isDark
                    ? [
                        'rgba(250, 204, 21, 0.86)',
                        'rgba(255, 44, 44, 0.86)',
                        'rgba(34, 197, 94, 0.86)'
                    ]
                    : [
                        'rgba(250, 204, 21, 0.72)',
                        'rgba(255, 44, 44, 0.72)',
                        'rgba(34, 197, 94, 0.72)'
                    ],
            };
        }

        function createMonthlyGradient() {
            const isDark = isInventraDarkMode();

            const gradient = monthlyCtx.getContext('2d').createLinearGradient(0, 0, 0, 320);

            if (isDark) {
                gradient.addColorStop(0, 'rgba(255, 44, 44, 0.95)');
                gradient.addColorStop(0.55, 'rgba(255, 128, 79, 0.65)');
                gradient.addColorStop(1, 'rgba(255, 193, 7, 0.25)');
            } else {
                gradient.addColorStop(0, 'rgba(255, 44, 44, 0.85)');
                gradient.addColorStop(0.55, 'rgba(255, 128, 79, 0.45)');
                gradient.addColorStop(1, 'rgba(255, 193, 7, 0.18)');
            }

            return gradient;
        }

        function applyReportChartTheme() {
            const theme = getReportChartTheme();

            if (monthlyBorrowingChart) {
                monthlyBorrowingChart.data.datasets[0].backgroundColor = createMonthlyGradient();
                monthlyBorrowingChart.data.datasets[0].borderColor = theme.barBorder;
                monthlyBorrowingChart.options.scales.x.ticks.color = theme.tickColor;
                monthlyBorrowingChart.options.scales.y.ticks.color = theme.tickColor;
                monthlyBorrowingChart.options.scales.y.grid.color = theme.gridColor;
                monthlyBorrowingChart.options.plugins.tooltip.backgroundColor = theme.tooltipBg;
                monthlyBorrowingChart.options.plugins.tooltip.titleColor = theme.tooltipText;
                monthlyBorrowingChart.options.plugins.tooltip.bodyColor = theme.tooltipText;
                monthlyBorrowingChart.update();
            }

            if (statusDistributionChart) {
                statusDistributionChart.data.datasets[0].backgroundColor = theme.doughnutColors;
                statusDistributionChart.data.datasets[0].borderColor = [
                    theme.doughnutBorder,
                    theme.doughnutBorder,
                    theme.doughnutBorder,
                ];
                statusDistributionChart.options.plugins.tooltip.backgroundColor = theme.tooltipBg;
                statusDistributionChart.options.plugins.tooltip.titleColor = theme.tooltipText;
                statusDistributionChart.options.plugins.tooltip.bodyColor = theme.tooltipText;
                statusDistributionChart.update();
            }
        }

        if (monthlyCtx) {
            const theme = getReportChartTheme();

            monthlyBorrowingChart = new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: @json($monthlyChartLabels),
                    datasets: [{
                        label: 'Jumlah Peminjaman',
                        data: @json($monthlyChartData),
                        backgroundColor: createMonthlyGradient(),
                        borderColor: theme.barBorder,
                        borderWidth: 1,
                        borderRadius: 18,
                        maxBarThickness: 44
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: theme.tooltipBg,
                            titleColor: theme.tooltipText,
                            bodyColor: theme.tooltipText,
                            padding: 12,
                            cornerRadius: 12
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: theme.tickColor,
                                font: {
                                    weight: '700'
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: theme.gridColor
                            },
                            ticks: {
                                precision: 0,
                                color: theme.tickColor,
                                font: {
                                    weight: '700'
                                }
                            }
                        }
                    }
                }
            });
        }

        if (statusCtx) {
            const theme = getReportChartTheme();

            statusDistributionChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($statusChartLabels),
                    datasets: [{
                        data: @json($statusChartData),
                        backgroundColor: theme.doughnutColors,
                        borderColor: [
                            theme.doughnutBorder,
                            theme.doughnutBorder,
                            theme.doughnutBorder,
                        ],
                        borderWidth: 2,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: theme.tooltipBg,
                            titleColor: theme.tooltipText,
                            bodyColor: theme.tooltipText,
                            padding: 12,
                            cornerRadius: 12
                        }
                    }
                }
            });
        }

        const reportThemeObserver = new MutationObserver(function () {
            applyReportChartTheme();
        });

        reportThemeObserver.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });
    </script>

    <style>
        html.dark .inventra-report-action {
            background-color: #334155 !important;
            color: #f8fafc !important;
            border: 1px solid #475569 !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25) !important;
        }

        html.dark .inventra-report-action:hover {
            background-color: #475569 !important;
        }

        html.dark .inventra-report-dropdown {
            background-color: #111827 !important;
            border-color: #334155 !important;
        }

        html.dark .inventra-report-dropdown-item {
            color: #e2e8f0 !important;
        }

        html.dark .inventra-report-dropdown-item:hover {
            background-color: #1e293b !important;
            color: #ffffff !important;
        }

        html.dark .inventra-report-soft-card {
            background-color: #172033 !important;
            border-color: #2a3850 !important;
        }

        html.dark .inventra-report-table-head {
            background-color: #172033 !important;
        }

        html.dark .inventra-report-table-head th {
            color: #cbd5e1 !important;
        }

        html.dark .inventra-report-table tbody tr {
            border-color: #223047 !important;
        }

        html.dark .inventra-report-table tbody tr:hover {
            background-color: rgba(30, 41, 59, 0.65) !important;
        }

        html.dark .inventra-report-data-badge {
            background-color: rgba(255, 44, 44, 0.18) !important;
            color: #ff8a8a !important;
            border-color: rgba(255, 44, 44, 0.28) !important;
        }

        @media print {
            aside,
            nav,
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .bg-white {
                box-shadow: none !important;
            }
        }
    </style>
</x-app-layout>
