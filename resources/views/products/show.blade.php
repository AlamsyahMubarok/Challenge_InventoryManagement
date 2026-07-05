<x-app-layout>
    @php
        $conditionBadgeClass = match ($product->condition) {
            'Baik' => 'bg-green-50 text-green-600 border border-green-100',
            'Rusak Ringan' => 'bg-orange-50 text-orange-600 border border-orange-100',
            'Rusak Berat', 'Rusak Parah' => 'bg-red-50 text-red-600 border border-red-100',
            'Maintenance' => 'bg-yellow-50 text-yellow-700 border border-yellow-100',
            default => 'bg-slate-100 text-slate-600 border border-slate-200',
        };
    @endphp

    <div class="space-y-6">

        <div>
            <p class="text-sm font-semibold text-red-500 mb-2">
                Manajemen Barang
            </p>

            <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                Detail Barang
            </h1>

            <p class="mt-2 text-slate-500">
                Informasi lengkap terkait data barang inventaris.
            </p>
        </div>

        <div class="max-w-6xl">
            <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-sm border border-slate-100">

                <div class="grid grid-cols-1 lg:grid-cols-[360px_minmax(0,1fr)] gap-8">
                    <div>
                        <p class="text-sm font-bold text-slate-400 mb-3">
                            Gambar Barang
                        </p>

                        @if ($product->image_url)
                            <img src="{{ $product->image_url }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-[360px] rounded-3xl object-cover border border-slate-100 bg-slate-50">
                        @else
                            <div class="w-full h-[360px] rounded-3xl bg-slate-50 border border-slate-100 flex items-center justify-center">
                                <p class="text-sm font-semibold text-slate-400">
                                    Belum ada gambar barang.
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="rounded-3xl bg-slate-50 p-5">
                                <p class="text-sm font-semibold text-slate-400">
                                    Kode Barang
                                </p>

                                <p class="mt-2 text-lg font-extrabold text-slate-900">
                                    {{ $product->code }}
                                </p>
                            </div>

                            <div class="rounded-3xl bg-slate-50 p-5">
                                <p class="text-sm font-semibold text-slate-400">
                                    Nama Barang
                                </p>

                                <p class="mt-2 text-lg font-extrabold text-slate-900">
                                    {{ $product->name }}
                                </p>
                            </div>

                            <div class="rounded-3xl bg-slate-50 p-5">
                                <p class="text-sm font-semibold text-slate-400">
                                    Kategori
                                </p>

                                <span class="inline-flex mt-3 px-3 py-1.5 rounded-full bg-sky-50 text-sky-600 border border-sky-100 text-xs font-bold">
                                    {{ $product->category->name }}
                                </span>
                            </div>

                            <div class="rounded-3xl bg-slate-50 p-5">
                                <p class="text-sm font-semibold text-slate-400">
                                    Status Barang
                                </p>

                                <span class="inline-flex mt-3 px-3 py-1.5 rounded-full text-xs font-bold {{ $product->inventory_status_badge_class }}">
                                    {{ $product->inventory_status }}
                                </span>
                            </div>

                            <div class="rounded-3xl bg-slate-50 p-5">
                                <p class="text-sm font-semibold text-slate-400">
                                    Kondisi Utama
                                </p>

                                <span class="inline-flex mt-3 px-3 py-1.5 rounded-full text-xs font-bold {{ $conditionBadgeClass }}">
                                    {{ $product->condition }}
                                </span>
                            </div>

                            <div class="rounded-3xl bg-slate-50 p-5">
                                <p class="text-sm font-semibold text-slate-400">
                                    Lokasi
                                </p>

                                <p class="mt-2 text-lg font-extrabold text-slate-900">
                                    {{ $product->location }}
                                </p>
                            </div>
                        </div>

                        <div class="rounded-3xl bg-slate-50 p-5">
                            <p class="text-sm font-semibold text-slate-400">
                                Deskripsi
                            </p>

                            <p class="mt-3 text-sm leading-7 text-slate-700">
                                {{ $product->description ?: 'Belum ada deskripsi.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-xl font-extrabold text-slate-900">
                        Rincian Stok Barang
                    </h3>

                    <p class="mt-1 text-sm text-slate-400">
                        Perincian jumlah barang berdasarkan status pemakaian dan kondisi fisik.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mt-5">
                        <div class="rounded-3xl bg-green-50 border border-green-100 p-5">
                            <p class="text-sm font-bold text-green-600">
                                Siap Dipinjam
                            </p>

                            <p class="mt-3 text-3xl font-extrabold text-slate-900">
                                {{ $product->stock }}
                            </p>
                        </div>

                        <div class="rounded-3xl bg-yellow-50 border border-yellow-100 p-5">
                            <p class="text-sm font-bold text-yellow-700">
                                Sedang Dipinjam
                            </p>

                            <p class="mt-3 text-3xl font-extrabold text-slate-900">
                                {{ $product->borrowed_quantity ?? 0 }}
                            </p>
                        </div>

                        <div class="rounded-3xl bg-orange-50 border border-orange-100 p-5">
                            <p class="text-sm font-bold text-orange-600">
                                Rusak Ringan
                            </p>

                            <p class="mt-3 text-3xl font-extrabold text-slate-900">
                                {{ $product->light_damage_stock }}
                            </p>
                        </div>

                        <div class="rounded-3xl bg-red-50 border border-red-100 p-5">
                            <p class="text-sm font-bold text-red-600">
                                Rusak Berat
                            </p>

                            <p class="mt-3 text-3xl font-extrabold text-slate-900">
                                {{ $product->heavy_damage_stock }}
                            </p>
                        </div>

                        <div class="rounded-3xl bg-yellow-50 border border-yellow-100 p-5">
                            <p class="text-sm font-bold text-yellow-700">
                                Maintenance
                            </p>

                            <p class="mt-3 text-3xl font-extrabold text-slate-900">
                                {{ $product->maintenance_stock }}
                            </p>
                        </div>

                        <div class="rounded-3xl bg-slate-50 border border-slate-100 p-5">
                            <p class="text-sm font-bold text-slate-500">
                                Batas Stok Menipis
                            </p>

                            <p class="mt-3 text-3xl font-extrabold text-slate-900">
                                {{ $product->minimum_stock }}
                            </p>
                        </div>

                        <div class="rounded-3xl bg-slate-50 border border-slate-100 p-5">
                            <p class="text-sm font-bold text-slate-500">
                                Tidak Siap Dipinjam
                            </p>

                            <p class="mt-3 text-3xl font-extrabold text-slate-900">
                                {{ $product->unavailable_stock }}
                            </p>
                        </div>

                        <div class="rounded-3xl bg-slate-900 p-5">
                            <p class="text-sm font-bold text-white/70">
                                Total Fisik
                            </p>

                            <p class="mt-3 text-3xl font-extrabold text-white">
                                {{ $product->total_physical_stock }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-8">
                    <a href="{{ route('products.index') }}"
                       class="px-5 py-3 rounded-2xl bg-slate-100 text-slate-700 text-sm font-bold hover:bg-slate-200 transition">
                        Kembali
                    </a>

                    <a href="{{ route('products.edit', $product) }}"
                       class="px-5 py-3 rounded-2xl bg-[#FF2C2C] text-white text-sm font-bold shadow-sm hover:bg-[#D91F1F] transition">
                        Edit
                    </a>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>
