<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Inventaris
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Jenis Barang</p>
                    <h3 class="text-2xl font-bold">{{ $totalProductTypes }}</h3>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Stok Tersedia</p>
                    <h3 class="text-2xl font-bold">{{ $availableStock }}</h3>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Barang Dipinjam</p>
                    <h3 class="text-2xl font-bold">{{ $borrowedQuantity }}</h3>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Transaksi Selesai</p>
                    <h3 class="text-2xl font-bold">{{ $returnedBorrowings }}</h3>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="font-semibold text-lg mb-4">
                        Grafik Peminjaman Per Bulan
                    </h3>

                    <canvas id="borrowingChart" height="120"></canvas>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="font-semibold text-lg mb-4">
                        Peminjaman Terbaru
                    </h3>

                    <div class="overflow-hidden">
                        <table class="min-w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm">Peminjam</th>
                                    <th class="px-4 py-2 text-left text-sm">Barang</th>
                                    <th class="px-4 py-2 text-left text-sm">Status</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @forelse ($latestBorrowings as $borrowing)
                                    <tr>
                                        <td class="px-4 py-2 text-sm">
                                            {{ $borrowing->borrower_name ?? $borrowing->user->name }}
                                        </td>

                                        <td class="px-4 py-2 text-sm">
                                            {{ $borrowing->details->pluck('product.name')->join(', ') }}
                                        </td>

                                        <td class="px-4 py-2 text-sm">
                                            @if ($borrowing->status === 'borrowed')
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs">
                                                    Dipinjam
                                                </span>
                                            @else
                                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">
                                                    Dikembalikan
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-3 text-center text-gray-500">
                                            Belum ada data peminjaman.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('borrowingChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($monthlyChartLabels),
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: @json($monthlyChartData),
                    borderWidth: 2,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
