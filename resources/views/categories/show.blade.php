<x-app-layout>
    <div class="space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <p class="text-sm font-bold text-[#FF2C2C] mb-2">
                    Detail Kategori
                </p>

                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                    {{ $category->name }}
                </h1>

                <p class="mt-3 text-slate-500 max-w-2xl">
                    {{ $category->description ?: 'Belum ada deskripsi kategori.' }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('categories.index') }}"
                   class="inventra-visible-button inline-flex items-center justify-center h-12 px-5 rounded-2xl bg-white border border-slate-100 text-sm font-bold text-slate-700 hover:bg-slate-50 transition">
                    Kembali
                </a>

                <a href="{{ route('categories.edit', $category) }}"
                   class="inline-flex items-center justify-center h-12 px-5 rounded-2xl bg-[#F59E0B] text-sm font-bold text-white hover:bg-[#D97706] transition">
                    Edit Kategori
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="rounded-3xl bg-white border border-slate-100 shadow-sm p-6">
                <p class="text-sm font-bold text-slate-400">Jumlah Barang</p>
                <h2 class="mt-4 text-3xl font-extrabold text-slate-900">
                    {{ $totalProducts }}
                </h2>
            </div>

            <div class="rounded-3xl bg-white border border-slate-100 shadow-sm p-6">
                <p class="text-sm font-bold text-slate-400">Stok Tersedia</p>
                <h2 class="mt-4 text-3xl font-extrabold text-slate-900">
                    {{ $availableStock }}
                </h2>
            </div>

            <div class="rounded-3xl bg-white border border-slate-100 shadow-sm p-6">
                <p class="text-sm font-bold text-slate-400">Stok Menipis</p>
                <h2 class="mt-4 text-3xl font-extrabold text-red-500">
                    {{ $lowStockProductsCount }}
                </h2>
            </div>
        </div>

        <div class="rounded-3xl bg-white border border-slate-100 shadow-sm p-5">
            <form method="GET" action="{{ route('categories.show', $category) }}" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-5 h-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                        </svg>
                    </div>

                    <input type="text"
                           name="search"
                           value="{{ $search }}"
                           placeholder="Cari kode, nama, lokasi, atau kondisi barang..."
                           class="w-full h-12 rounded-2xl border-slate-200 pl-12 pr-4 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]">
                </div>

                <button type="submit"
                        class="h-12 px-6 rounded-2xl bg-slate-900 text-white text-sm font-bold hover:bg-slate-800 transition">
                    Cari
                </button>
            </form>
        </div>

        <div class="rounded-3xl bg-white border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6">
                <h2 class="text-xl font-extrabold text-slate-900">
                    Barang dalam Kategori {{ $category->name }}
                </h2>

                <p class="mt-2 text-sm text-slate-400">
                    Klik salah satu barang untuk melihat detail barang.
                </p>
            </div>

            <div class="overflow-x-auto px-6 pb-6">
                <table class="w-full min-w-[950px]">
                    <thead>
                        <tr class="bg-slate-50 text-left">
                            <th class="px-4 py-4 rounded-l-2xl text-sm font-bold text-slate-500">No</th>
                            <th class="px-4 py-4 text-sm font-bold text-slate-500">Barang</th>
                            <th class="px-4 py-4 text-sm font-bold text-slate-500">Kode</th>
                            <th class="px-4 py-4 text-sm font-bold text-slate-500">Stok</th>
                            <th class="px-4 py-4 text-sm font-bold text-slate-500">Status</th>
                            <th class="px-4 py-4 text-sm font-bold text-slate-500">Lokasi</th>
                            <th class="px-4 py-4 text-sm font-bold text-slate-500">Kondisi</th>
                            <th class="px-4 py-4 rounded-r-2xl text-sm font-bold text-slate-500 text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($products as $product)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-5 text-sm text-slate-500">
                                    {{ $products->firstItem() + $loop->index }}
                                </td>

                                <td class="px-4 py-5">
                                    <a href="{{ route('products.show', $product) }}"
                                       class="flex items-center gap-4 group">
                                        <div class="w-14 h-14 rounded-2xl bg-slate-50 border border-slate-100 overflow-hidden flex items-center justify-center shrink-0">
                                            @if ($product->image_url)
                                                <img src="{{ $product->image_url }}"
                                                     alt="{{ $product->name }}"
                                                     class="w-full h-full object-cover">
                                            @else
                                                <span class="text-[10px] font-bold text-slate-400">
                                                    No Img
                                                </span>
                                            @endif
                                        </div>

                                        <div>
                                            <p class="text-sm font-extrabold text-slate-900 group-hover:text-[#FF2C2C] transition">
                                                {{ $product->name }}
                                            </p>

                                            <p class="mt-1 text-xs font-semibold text-slate-400 line-clamp-1">
                                                {{ $product->description ?: 'Tidak ada deskripsi.' }}
                                            </p>
                                        </div>
                                    </a>
                                </td>

                                <td class="px-4 py-5 text-sm font-bold text-slate-700">
                                    {{ $product->code }}
                                </td>

                                <td class="px-4 py-5 text-sm font-extrabold text-slate-900">
                                    {{ $product->stock }}
                                </td>

                                <td class="px-4 py-5">
                                    <div class="flex flex-col gap-2 items-start">
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold {{ $product->inventory_status_badge_class }}">
                                            {{ $product->inventory_status }}
                                        </span>

                                        @if ($product->is_low_stock)
                                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                                Stok Menipis
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-4 py-5 text-sm text-slate-500">
                                    {{ $product->location }}
                                </td>

                                <td class="px-4 py-5">
                                    @php
                                        $conditionClass = match ($product->condition) {
                                            'Baik' => 'bg-green-50 text-green-600 border border-green-100',
                                            'Rusak Ringan' => 'bg-orange-50 text-orange-600 border border-orange-100',
                                            'Rusak Berat' => 'bg-red-50 text-red-600 border border-red-100',
                                            'Maintenance' => 'bg-yellow-50 text-yellow-700 border border-yellow-100',
                                            default => 'bg-slate-100 text-slate-600 border border-slate-200',
                                        };
                                    @endphp

                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold {{ $conditionClass }}">
                                        {{ $product->condition }}
                                    </span>
                                </td>

                                <td class="px-4 py-5 text-right">
                                    <a href="{{ route('products.show', $product) }}"
                                       class="inline-flex items-center justify-center h-10 px-4 rounded-xl bg-slate-100 text-sm font-bold text-slate-700 hover:bg-slate-200 transition">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-12 text-center">
                                    <p class="text-sm font-bold text-slate-500">
                                        Tidak ada barang dalam kategori ini.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($products->hasPages())
                <div class="px-6 pb-6">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
