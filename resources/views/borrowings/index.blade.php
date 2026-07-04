<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Riwayat Peminjaman
            </h2>

            <a href="{{ route('borrowings.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                Tambah Peminjaman
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-4 bg-white p-4 rounded-lg shadow">
                <form method="GET" action="{{ route('borrowings.index') }}" class="flex gap-2">
                    <input type="text"
                           name="search"
                           value="{{ $search }}"
                           placeholder="Cari peminjam, barang, kode, atau status..."
                           class="w-full border-gray-300 rounded-md shadow-sm">

                    <button type="submit"
                            class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm">
                        Cari
                    </button>

                    @if ($search)
                        <a href="{{ route('borrowings.index') }}"
                           class="px-4 py-2 bg-gray-200 rounded-md text-sm">
                            Reset
                        </a>
                    @endif
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
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Aksi</th>
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

                                <td class="px-6 py-4 text-sm text-right">
                                    <a href="{{ route('borrowings.show', $borrowing) }}"
                                       class="text-blue-600 hover:underline">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada data peminjaman.
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
