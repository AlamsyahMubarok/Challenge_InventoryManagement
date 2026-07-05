<x-app-layout>
    <div class="space-y-6">

        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-semibold text-red-500 mb-2">
                    Manajemen Peminjaman
                </p>

                <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Riwayat Peminjaman
                </h1>

                <p class="mt-2 text-slate-500">
                    Pantau transaksi peminjaman, batas pengembalian, dan status barang.
                </p>
            </div>

            <a href="{{ route('borrowings.create') }}"
               class="inline-flex items-center justify-center px-5 py-3 rounded-2xl bg-[#FF2C2C] text-white text-sm font-bold shadow-sm hover:bg-[#D91F1F] transition">
                Tambah Peminjaman
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-2xl bg-green-50 border border-green-100 px-5 py-4 text-green-700 text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-2xl bg-red-50 border border-red-100 px-5 py-4 text-red-700 text-sm font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                <p class="text-sm font-semibold text-slate-400">
                    Total Peminjaman
                </p>

                <h3 class="mt-3 text-4xl font-extrabold text-slate-900">
                    {{ $borrowings->total() }}
                </h3>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                <p class="text-sm font-semibold text-slate-400">
                    Hasil Ditampilkan
                </p>

                <h3 class="mt-3 text-4xl font-extrabold text-slate-900">
                    {{ $borrowings->count() }}
                </h3>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100">
            <form method="GET" action="{{ route('borrowings.index') }}" class="flex flex-col md:flex-row gap-3">
                <div class="relative flex-1">
                    <input type="text"
                           name="search"
                           value="{{ $search ?? '' }}"
                           placeholder="Cari peminjam, barang, kode, status, atau terlambat..."
                           class="w-full h-12 rounded-2xl border-slate-200 pr-4 pl-12 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]">

                    <div class="absolute inset-y-0 left-4 flex items-center text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-5 h-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
                        </svg>
                    </div>
                </div>

                <button type="submit"
                        class="h-12 px-5 rounded-2xl bg-slate-900 text-white text-sm font-bold hover:bg-slate-800 transition">
                    Cari
                </button>

                @if ($search)
                    <a href="{{ route('borrowings.index') }}"
                       class="h-12 px-5 rounded-2xl bg-slate-100 text-slate-700 text-sm font-bold hover:bg-slate-200 transition inline-flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-900">
                        Daftar Peminjaman
                    </h3>

                    <p class="text-sm text-slate-400 mt-1">
                        Data transaksi peminjaman yang tercatat di sistem Inventra.
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-[1050px] w-full">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500 rounded-l-2xl">
                                No
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500">
                                Peminjam
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500">
                                Barang
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500">
                                Tanggal Pinjam
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500">
                                Batas Kembali
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500">
                                Status
                            </th>

                            <th class="px-5 py-4 text-right text-sm font-bold text-slate-500 rounded-r-2xl">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($borrowings as $borrowing)
                            @php
                                $isOverdue = $borrowing->status === 'borrowed' && $borrowing->isOverdue();

                                $statusLabel = match (true) {
                                    $isOverdue => 'Terlambat',
                                    $borrowing->status === 'borrowed' => 'Dipinjam',
                                    $borrowing->status === 'returned' => 'Dikembalikan',
                                    default => ucfirst($borrowing->status),
                                };

                                $statusBadgeClass = match (true) {
                                    $isOverdue => 'bg-red-50 text-red-600 border border-red-100',
                                    $borrowing->status === 'borrowed' => 'bg-yellow-50 text-yellow-700 border border-yellow-100',
                                    $borrowing->status === 'returned' => 'bg-green-50 text-green-600 border border-green-100',
                                    default => 'bg-slate-100 text-slate-600 border border-slate-200',
                                };
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

                                <td class="px-5 py-4 text-sm">
                                    <span class="inline-flex items-center justify-center whitespace-nowrap px-3 py-1.5 rounded-full text-xs font-bold {{ $statusBadgeClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-sm text-right">
                                    <a href="{{ route('borrowings.show', $borrowing) }}"
                                       class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200 transition">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-10 text-center text-slate-400">
                                    Tidak ada data peminjaman yang ditemukan.
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

                <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
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
</x-app-layout>
