<x-app-layout>
    @php
        $role = Auth::user()->role?->name;
        $canManageInventory = in_array($role, ['admin', 'staff']);
        $canViewReports = in_array($role, ['admin', 'manager']);

        $notificationIcon = $lowStockCount > 0
            ? asset('images/notification_2.png')
            : asset('images/notification.png');
    @endphp

    <div x-data="{ notificationOpen: false }" class="space-y-6">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-red-500 mb-2">
                    Dashboard Inventaris
                </p>

                <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Halo, {{ Auth::user()->name }}
                </h1>

                <p class="mt-2 text-slate-500">
                    Pantau stok, peminjaman, dan aktivitas inventaris Inventra.
                </p>
            </div>

            <div class="flex items-start gap-3 sm:justify-end">
                <button type="button"
                        data-theme-toggle
                        class="inventra-visible-button inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-white border border-slate-100 shadow-sm hover:bg-slate-50 transition"
                        title="Ubah Tema"
                        aria-label="Ubah tema">
                    <svg data-theme-icon="moon"
                         xmlns="http://www.w3.org/2000/svg"
                         class="w-7 h-7 text-slate-700"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                    </svg>

                    <svg data-theme-icon="sun"
                         xmlns="http://www.w3.org/2000/svg"
                         class="hidden w-7 h-7 text-yellow-500"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364-.707-.707M6.343 6.343l-.707-.707m12.728 0-.707.707M6.343 17.657l-.707.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                    </svg>
                </button>

                <div class="relative" @click.outside="notificationOpen = false">
                    <button type="button"
                            @click="notificationOpen = ! notificationOpen"
                            class="inventra-visible-button inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-white border border-slate-100 shadow-sm hover:bg-slate-50 transition"
                            title="Notifikasi Stok"
                            aria-label="Notifikasi stok">
                        <img src="{{ $notificationIcon }}?v=10"
                             alt="Notifikasi"
                             class="w-9 h-9 object-contain">
                    </button>

                    <div x-show="notificationOpen"
                         x-transition
                         style="display: none;"
                         class="absolute right-0 z-50 mt-4 w-[380px] max-w-[calc(100vw-2rem)] rounded-3xl bg-white border border-slate-100 shadow-xl overflow-hidden">
                        <div class="p-5 border-b border-slate-100">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h3 class="text-lg font-extrabold text-slate-900">
                                        Notifikasi Stok
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-400 leading-6">
                                        Barang dengan stok siap dipinjam yang sudah mencapai batas minimum.
                                    </p>
                                </div>

                                <span class="shrink-0 inline-flex items-center justify-center px-3 py-1.5 rounded-full bg-red-50 text-red-600 border border-red-100 text-xs font-extrabold">
                                    {{ $lowStockCount }}
                                </span>
                            </div>
                        </div>

                        <div class="p-5">
                            @if ($lowStockProducts->isEmpty())
                                <div class="rounded-2xl bg-green-50 border border-green-100 p-4">
                                    <p class="text-sm font-bold text-green-600">
                                        Semua stok masih aman.
                                    </p>

                                    <p class="mt-1 text-xs font-semibold text-green-500">
                                        Tidak ada barang yang berada di bawah batas minimum.
                                    </p>
                                </div>
                            @else
                                <div class="max-h-[320px] overflow-y-auto pr-1 space-y-3">
                                    @foreach ($lowStockProducts as $product)
                                        @if ($canManageInventory)
                                            <a href="{{ route('products.show', $product) }}"
                                               class="flex items-center justify-between gap-4 rounded-2xl bg-slate-50 border border-slate-100 p-4 hover:bg-red-50 hover:border-red-100 transition">
                                                <div class="flex items-center gap-3 min-w-0">
                                                    @if ($product->image_url)
                                                        <img src="{{ $product->image_url }}"
                                                             alt="{{ $product->name }}"
                                                             class="w-11 h-11 rounded-2xl object-cover bg-white border border-slate-100">
                                                    @else
                                                        <div class="w-11 h-11 rounded-2xl bg-white border border-slate-100 flex items-center justify-center">
                                                            <span class="text-[10px] font-bold text-slate-400">
                                                                No Img
                                                            </span>
                                                        </div>
                                                    @endif

                                                    <div class="min-w-0">
                                                        <p class="text-sm font-extrabold text-slate-900 truncate">
                                                            {{ $product->name }}
                                                        </p>

                                                        <p class="mt-1 text-xs font-semibold text-slate-400 truncate">
                                                            {{ $product->category->name }} · Minimum {{ $product->minimum_stock }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="shrink-0 inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-extrabold {{ $product->stock_alert_badge_class }}">
                                                    Stok {{ $product->stock }}
                                                </span>
                                            </a>
                                        @else
                                            <div class="flex items-center justify-between gap-4 rounded-2xl bg-slate-50 border border-slate-100 p-4">
                                                <div class="flex items-center gap-3 min-w-0">
                                                    @if ($product->image_url)
                                                        <img src="{{ $product->image_url }}"
                                                             alt="{{ $product->name }}"
                                                             class="w-11 h-11 rounded-2xl object-cover bg-white border border-slate-100">
                                                    @else
                                                        <div class="w-11 h-11 rounded-2xl bg-white border border-slate-100 flex items-center justify-center">
                                                            <span class="text-[10px] font-bold text-slate-400">
                                                                No Img
                                                            </span>
                                                        </div>
                                                    @endif

                                                    <div class="min-w-0">
                                                        <p class="text-sm font-extrabold text-slate-900 truncate">
                                                            {{ $product->name }}
                                                        </p>

                                                        <p class="mt-1 text-xs font-semibold text-slate-400 truncate">
                                                            {{ $product->category->name }} · Minimum {{ $product->minimum_stock }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <span class="shrink-0 inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-extrabold {{ $product->stock_alert_badge_class }}">
                                                    Stok {{ $product->stock }}
                                                </span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                @if ($lowStockCount > $lowStockProducts->count())
                                    <p class="mt-4 text-xs font-semibold text-slate-400 text-center">
                                        Masih ada {{ $lowStockCount - $lowStockProducts->count() }} barang stok menipis lainnya.
                                    </p>
                                @endif

                                @if ($canManageInventory)
                                    <a href="{{ route('products.index', ['stock_status' => 'low_stock']) }}"
                                       class="mt-5 inline-flex w-full items-center justify-center px-4 py-3 rounded-2xl bg-[#FF2C2C] text-white text-sm font-bold hover:bg-[#D91F1F] transition">
                                        Lihat Barang Stok Menipis
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-[minmax(0,1fr)_400px] gap-6 items-start">

            <div class="space-y-6">

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
                    <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-slate-400 leading-tight">
                                    Jenis<br>
                                    Barang
                                </p>

                                <h3 class="mt-3 text-3xl font-extrabold text-slate-900">
                                    {{ $totalProductTypes }}
                                </h3>
                            </div>

                            <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center">
                                <img src="{{ asset('images/kategori.png') }}?v=120"
                                     alt="Kategori"
                                     class="w-9 h-9 object-contain">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-slate-400 leading-tight">
                                    Stok<br>
                                    Tersedia
                                </p>

                                <h3 class="mt-3 text-3xl font-extrabold text-slate-900">
                                    {{ $availableStock }}
                                </h3>
                            </div>

                            <div class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center">
                                <img src="{{ asset('images/barang.png') }}?v=120"
                                     alt="Barang"
                                     class="w-9 h-9 object-contain">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-slate-400 leading-tight">
                                    Barang<br>
                                    Dipinjam
                                </p>

                                <h3 class="mt-3 text-3xl font-extrabold text-slate-900">
                                    {{ $borrowedQuantity }}
                                </h3>
                            </div>

                            <div class="w-14 h-14 rounded-2xl bg-yellow-50 flex items-center justify-center">
                                <img src="{{ asset('images/peminjaman.png') }}?v=120"
                                     alt="Peminjaman"
                                     class="w-9 h-9 object-contain">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-slate-400 leading-tight">
                                    Transaksi<br>
                                    Selesai
                                </p>

                                <h3 class="mt-3 text-3xl font-extrabold text-slate-900">
                                    {{ $returnedBorrowings }}
                                </h3>
                            </div>

                            <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center">
                                <img src="{{ asset('images/laporan.png') }}?v=120"
                                     alt="Laporan"
                                     class="w-9 h-9 object-contain">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-extrabold text-slate-900">
                                Grafik Peminjaman
                            </h3>

                            <p class="text-sm text-slate-400 mt-1">
                                Jumlah peminjaman per bulan pada tahun berjalan.
                            </p>
                        </div>

                        <div class="px-4 py-2 rounded-full bg-red-50 text-red-600 text-sm font-bold">
                            {{ now()->year }}
                        </div>
                    </div>

                    <div class="h-[340px]">
                        <canvas id="borrowingChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 max-h-[300px] overflow-hidden">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h3 class="text-xl font-extrabold text-slate-900">
                                Peminjaman Terbaru
                            </h3>

                            <p class="text-sm text-slate-400 mt-1">
                                Aktivitas peminjaman terakhir yang tercatat di sistem.
                            </p>
                        </div>

                        @if ($canManageInventory)
                            <a href="{{ route('borrowings.index') }}"
                               class="hidden sm:inline-flex px-4 py-2 rounded-2xl bg-red-50 text-red-600 text-sm font-bold hover:bg-red-100">
                                Lihat Semua
                            </a>
                        @endif
                    </div>

                    <div class="overflow-x-auto max-h-[190px]">
                        <table class="min-w-full">
                            <thead class="sticky top-0 z-10">
                                <tr class="bg-slate-50">
                                    <th class="px-5 py-4 text-left text-sm font-bold text-slate-500 rounded-l-2xl">
                                        Peminjam
                                    </th>

                                    <th class="px-5 py-4 text-left text-sm font-bold text-slate-500">
                                        Barang
                                    </th>

                                    <th class="px-5 py-4 text-left text-sm font-bold text-slate-500">
                                        Tanggal Pinjam
                                    </th>

                                    <th class="px-5 py-4 text-left text-sm font-bold text-slate-500 rounded-r-2xl">
                                        Status
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse ($latestBorrowings as $borrowing)
                                    <tr>
                                        <td class="px-5 py-4 text-sm font-semibold text-slate-700">
                                            {{ $borrowing->borrower_name ?? $borrowing->user->name }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-slate-500">
                                            {{ $borrowing->details->pluck('product.name')->join(', ') }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-slate-500">
                                            {{ $borrowing->borrow_date }}
                                        </td>

                                        <td class="px-5 py-4 text-sm">
                                            <span class="inline-flex items-center justify-center whitespace-nowrap px-3 py-1.5 rounded-full text-xs font-extrabold {{ $borrowing->status_badge_class }}">
                                                {{ $borrowing->status_label }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-8 text-center text-slate-400">
                                            Belum ada data peminjaman.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <aside class="hidden xl:flex flex-col gap-6 overflow-visible">

                <div class="rounded-3xl p-6 text-white shadow-sm overflow-hidden bg-gradient-to-br from-red-500 via-orange-500 to-yellow-400">
                    <div>
                        <p class="text-white/80 text-sm font-semibold">
                            Tanggal Sistem
                        </p>

                        <h3 id="dashboardDay" class="mt-3 text-3xl font-extrabold leading-tight">
                            -
                        </h3>

                        <p id="dashboardDate" class="mt-3 text-base font-semibold text-white/90">
                            -
                        </p>

                        <p class="mt-5 text-sm leading-7 text-white/85">
                            Gunakan informasi tanggal ini untuk memantau aktivitas peminjaman dan pengembalian barang.
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                    <p class="text-sm font-semibold text-slate-400">
                        Aksi Cepat
                    </p>

                    <div class="mt-5 space-y-3">
                        @if ($canManageInventory)
                            <a href="{{ route('borrowings.create') }}"
                               class="flex items-center justify-between px-4 py-3 rounded-2xl bg-red-50 text-red-600 font-bold text-sm hover:bg-red-100">
                                Tambah Peminjaman
                                <span>→</span>
                            </a>

                            <a href="{{ route('products.index') }}"
                               class="flex items-center justify-between px-4 py-3 rounded-2xl bg-slate-50 text-slate-700 font-bold text-sm hover:bg-slate-100">
                                Cek Data Barang
                                <span>→</span>
                            </a>
                        @endif

                        @if ($canViewReports)
                            <a href="{{ route('reports.index') }}"
                               class="flex items-center justify-between px-4 py-3 rounded-2xl bg-slate-50 text-slate-700 font-bold text-sm hover:bg-slate-100">
                                Lihat Laporan
                                <span>→</span>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="relative h-[430px] mt-4 overflow-visible">
                    <img src="{{ asset('images/gudang.png') }}?v=140"
                         alt="Ilustrasi Gudang"
                         class="absolute bottom-[-20px] right-[-35px] w-[430px] max-w-none object-contain pointer-events-none select-none">
                </div>

            </aside>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('borrowingChart');
        let borrowingChart = null;

        function isInventraDarkMode() {
            return document.documentElement.classList.contains('dark');
        }

        function getInventraChartTheme() {
            const isDark = isInventraDarkMode();

            return {
                tickColor: isDark ? '#cbd5e1' : '#94a3b8',
                gridColor: isDark ? 'rgba(148, 163, 184, 0.28)' : '#f1f5f9',
                lineColor: '#FF2C2C',
                fillColor: isDark ? 'rgba(255, 44, 44, 0.28)' : 'rgba(255, 44, 44, 0.12)',
                pointBorderColor: isDark ? '#020617' : '#ffffff',
            };
        }

        function applyInventraChartTheme() {
            if (! borrowingChart) {
                return;
            }

            const theme = getInventraChartTheme();

            borrowingChart.data.datasets[0].borderColor = theme.lineColor;
            borrowingChart.data.datasets[0].backgroundColor = theme.fillColor;
            borrowingChart.data.datasets[0].pointBackgroundColor = theme.lineColor;
            borrowingChart.data.datasets[0].pointBorderColor = theme.pointBorderColor;

            borrowingChart.options.scales.x.ticks.color = theme.tickColor;
            borrowingChart.options.scales.y.ticks.color = theme.tickColor;
            borrowingChart.options.scales.y.grid.color = theme.gridColor;

            borrowingChart.update();
        }

        if (ctx) {
            const chartTheme = getInventraChartTheme();

            borrowingChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($monthlyChartLabels),
                    datasets: [{
                        label: 'Jumlah Peminjaman',
                        data: @json($monthlyChartData),
                        borderColor: chartTheme.lineColor,
                        backgroundColor: chartTheme.fillColor,
                        fill: true,
                        borderWidth: 3,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: chartTheme.lineColor,
                        pointBorderColor: chartTheme.pointBorderColor,
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: chartTheme.tickColor,
                                font: {
                                    weight: '600'
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: chartTheme.gridColor
                            },
                            ticks: {
                                precision: 0,
                                color: chartTheme.tickColor,
                                font: {
                                    weight: '600'
                                }
                            }
                        }
                    }
                }
            });
        }

        const inventraThemeObserver = new MutationObserver(function () {
            applyInventraChartTheme();
        });

        inventraThemeObserver.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });

        function updateDashboardDate() {
            const now = new Date();

            const day = new Intl.DateTimeFormat('id-ID', {
                weekday: 'long'
            }).format(now);

            const date = new Intl.DateTimeFormat('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            }).format(now);

            document.getElementById('dashboardDay').textContent = day;
            document.getElementById('dashboardDate').textContent = date;
        }

        updateDashboardDate();
    </script>
</x-app-layout>
