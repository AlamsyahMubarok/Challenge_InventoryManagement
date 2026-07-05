<x-app-layout>
    @php
        $stockStatus = $stockStatus ?? null;

        $allQuery = [];

        if (filled($search ?? null)) {
            $allQuery['search'] = $search;
        }

        $lowStockQuery = $allQuery + [
            'stock_status' => 'low_stock',
        ];
    @endphp

    <div class="space-y-6">

        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-semibold text-red-500 mb-2">
                    Manajemen Barang
                </p>

                <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Data Barang
                </h1>

                <p class="mt-2 text-slate-500">
                    Kelola data barang, stok, lokasi, kondisi, dan status inventaris.
                </p>
            </div>

            <a href="{{ route('products.create') }}"
               class="inline-flex items-center justify-center px-5 py-3 rounded-2xl bg-[#FF2C2C] text-white text-sm font-bold shadow-sm hover:bg-[#D91F1F] transition">
                Tambah Barang
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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                <p class="text-sm font-semibold text-slate-400">
                    Total Barang
                </p>

                <h3 class="mt-3 text-4xl font-extrabold text-slate-900">
                    {{ $totalProducts }}
                </h3>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                <p class="text-sm font-semibold text-slate-400">
                    Hasil Ditampilkan
                </p>

                <h3 class="mt-3 text-4xl font-extrabold text-slate-900">
                    {{ $products->total() }}
                </h3>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                <p class="text-sm font-semibold text-slate-400">
                    Stok Menipis
                </p>

                <h3 class="mt-3 text-4xl font-extrabold text-red-500">
                    {{ $lowStockProductsCount }}
                </h3>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('products.index', $allQuery) }}"
               class="px-5 py-3 rounded-2xl text-sm font-bold transition {{ empty($stockStatus) ? 'bg-[#FF2C2C] text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-100 hover:bg-slate-50' }}">
                Semua Barang
            </a>

            <a href="{{ route('products.index', $lowStockQuery) }}"
               class="px-5 py-3 rounded-2xl text-sm font-bold transition {{ $stockStatus === 'low_stock' ? 'bg-[#FF2C2C] text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-100 hover:bg-slate-50' }}">
                Stok Menipis
            </a>
        </div>

        <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100">
            <form method="GET" action="{{ route('products.index') }}" class="flex flex-col md:flex-row gap-3">
                @if ($stockStatus)
                    <input type="hidden" name="stock_status" value="{{ $stockStatus }}">
                @endif

                <div class="relative flex-1">
                    <input type="text"
                           name="search"
                           value="{{ $search ?? '' }}"
                           placeholder="Cari kode, nama, kategori, lokasi, atau kondisi..."
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

                @if ($search || $stockStatus)
                    <a href="{{ route('products.index') }}"
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
                        Daftar Barang
                    </h3>

                    <p class="text-sm text-slate-400 mt-1">
                        Data barang yang tersedia di sistem Inventra.
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-[1550px] w-full">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500 rounded-l-2xl w-[70px]">
                                No
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500 min-w-[110px]">
                                Gambar
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500 min-w-[140px]">
                                Kode
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500 min-w-[240px]">
                                Nama
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500 min-w-[150px]">
                                Kategori
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500 w-[90px]">
                                Stok
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500 min-w-[190px]">
                                Status
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500 min-w-[180px]">
                                Lokasi
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500 min-w-[160px]">
                                Kondisi
                            </th>

                            <th class="px-5 py-4 text-right text-sm font-bold text-slate-500 rounded-r-2xl min-w-[220px]">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($products as $product)
                            @php
                                $conditionBadgeClass = match ($product->condition) {
                                    'Baik' => 'bg-green-50 text-green-600 border border-green-100',
                                    'Rusak Ringan' => 'bg-orange-50 text-orange-600 border border-orange-100',
                                    'Rusak Berat', 'Rusak Parah' => 'bg-red-50 text-red-600 border border-red-100',
                                    'Maintenance' => 'bg-yellow-50 text-yellow-700 border border-yellow-100',
                                    default => 'bg-slate-100 text-slate-600 border border-slate-200',
                                };
                            @endphp

                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="px-5 py-4 text-sm text-slate-500">
                                    {{ $products->firstItem() + $loop->index }}
                                </td>

                                <td class="px-5 py-4">
                                    @if ($product->image_url)
                                        <img src="{{ $product->image_url }}"
                                             alt="{{ $product->name }}"
                                             class="w-14 h-14 rounded-2xl object-cover border border-slate-100 bg-slate-50">
                                    @else
                                        <div class="w-14 h-14 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center">
                                            <span class="text-[10px] font-bold text-slate-400">
                                                No Img
                                            </span>
                                        </div>
                                    @endif
                                </td>

                                <td class="px-5 py-4 text-sm font-bold text-slate-800 whitespace-nowrap">
                                    {{ $product->code }}
                                </td>

                                <td class="px-5 py-4 text-sm text-slate-600">
                                    {{ $product->name }}
                                </td>

                                <td class="px-5 py-4 text-sm">
                                    <span class="inline-flex items-center justify-center whitespace-nowrap px-3 py-1.5 rounded-full bg-sky-50 text-sky-600 border border-sky-100 text-xs font-extrabold">
                                        {{ $product->category->name }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-sm font-bold text-slate-800">
                                    {{ $product->stock }}
                                </td>

                                <td class="px-5 py-4 text-sm">
                                    <div class="flex flex-col items-start gap-2">
                                        <span class="inline-flex items-center justify-center whitespace-nowrap px-3 py-1.5 rounded-full text-xs font-extrabold {{ $product->inventory_status_badge_class }}">
                                            {{ $product->inventory_status }}
                                        </span>

                                        @if ($product->is_low_stock)
                                            <span class="inline-flex items-center justify-center whitespace-nowrap px-3 py-1.5 rounded-full text-xs font-extrabold {{ $product->stock_alert_badge_class }}">
                                                {{ $product->stock_alert_label }}
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-sm text-slate-500">
                                    {{ $product->location }}
                                </td>

                                <td class="px-5 py-4 text-sm">
                                    <span class="inline-flex items-center justify-center whitespace-nowrap px-3 py-1.5 rounded-full text-xs font-extrabold {{ $conditionBadgeClass }}">
                                        {{ $product->condition }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-sm text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('products.show', $product) }}"
                                           class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200 transition">
                                            Detail
                                        </a>

                                        <a href="{{ route('products.edit', $product) }}"
                                           class="px-4 py-2 rounded-xl bg-amber-500 text-white text-xs font-bold hover:bg-amber-600 transition">
                                            Edit
                                        </a>

                                        <form action="{{ route('products.destroy', $product) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="px-4 py-2 rounded-xl bg-red-50 text-red-600 text-xs font-bold hover:bg-red-100 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-5 py-10 text-center text-slate-400">
                                    Tidak ada data barang yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($products->hasPages())
                @php
                    $currentPage = $products->currentPage();
                    $lastPage = $products->lastPage();
                    $startPage = max(1, $currentPage - 2);
                    $endPage = min($lastPage, $currentPage + 2);
                @endphp

                <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-slate-500">
                        Menampilkan
                        <span class="font-bold text-slate-700">{{ $products->firstItem() }}</span>
                        sampai
                        <span class="font-bold text-slate-700">{{ $products->lastItem() }}</span>
                        dari
                        <span class="font-bold text-slate-700">{{ $products->total() }}</span>
                        data
                    </p>

                    <div class="flex items-center gap-2">
                        @if ($products->onFirstPage())
                            <span class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-300 flex items-center justify-center cursor-not-allowed">
                                ‹
                            </span>
                        @else
                            <a href="{{ $products->previousPageUrl() }}"
                               class="w-10 h-10 rounded-2xl bg-white border border-slate-200 text-slate-600 flex items-center justify-center hover:bg-red-50 hover:text-red-600 hover:border-red-100 transition">
                                ‹
                            </a>
                        @endif

                        @if ($startPage > 1)
                            <a href="{{ $products->url(1) }}"
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
                                <a href="{{ $products->url($page) }}"
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

                            <a href="{{ $products->url($lastPage) }}"
                               class="w-10 h-10 rounded-2xl bg-white border border-slate-200 text-slate-600 text-sm font-bold flex items-center justify-center hover:bg-red-50 hover:text-red-600 hover:border-red-100 transition">
                                {{ $lastPage }}
                            </a>
                        @endif

                        @if ($products->hasMorePages())
                            <a href="{{ $products->nextPageUrl() }}"
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
