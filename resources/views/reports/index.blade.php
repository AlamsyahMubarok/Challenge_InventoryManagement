<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Inventaris
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Jenis Barang</p>
                    <h3 class="text-2xl font-bold">{{ $totalProducts }}</h3>
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
                    <p class="text-sm text-gray-500">Total Peminjaman</p>
                    <h3 class="text-2xl font-bold">{{ $totalBorrowings }}</h3>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Selesai</p>
                    <h3 class="text-2xl font-bold">{{ $returnedBorrowings }}</h3>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <form method="GET" action="{{ route('reports.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Dari Tanggal</label>
                        <input type="date"
                               name="date_from"
                               value="{{ $dateFrom }}"
                               class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Sampai Tanggal</label>
                        <input type="date"
                               name="date_to"
                               value="{{ $dateTo }}"
                               class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Status</label>
                        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Semua Status</option>
                            <option value="borrowed" @selected($status === 'borrowed')>Dipinjam</option>
                            <option value="returned" @selected($status === 'returned')>Dikembalikan</option>
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit"
                                class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm">
                            Filter
                        </button>

                        <a href="{{ route('reports.index') }}"
                           class="px-4 py-2 bg-gray-200 rounded-md text-sm">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">No</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Peminjam</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Barang</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tanggal Pinjam</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tanggal Kembali</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @forelse ($borrowings as $borrowing)
                            <tr>
                                <td class="px-6 py-4 text-sm">
                                    {{ $borrowings->firstItem() + $loop->index }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    {{ $borrowing->borrower_name ?? $borrowing->user->name }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    {{ $borrowing->details->pluck('product.name')->join(', ') }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    {{ $borrowing->borrow_date }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    {{ $borrowing->return_date ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-sm">
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
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    Tidak ada data laporan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $borrowings->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
