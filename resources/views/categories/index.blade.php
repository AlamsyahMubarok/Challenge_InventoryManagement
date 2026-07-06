<x-app-layout>
    <div class="space-y-6">

        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-semibold text-red-500 mb-2">
                    Manajemen Kategori
                </p>

                <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Data Kategori
                </h1>

                <p class="mt-2 text-slate-500">
                    Kelola kategori barang untuk memudahkan pengelompokan inventaris.
                </p>
            </div>

            <a href="{{ route('categories.create') }}"
               class="inline-flex items-center justify-center px-5 py-3 rounded-2xl bg-[#FF2C2C] text-white text-sm font-bold shadow-sm hover:bg-[#D91F1F] transition">
                Tambah Kategori
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
                    Total Kategori
                </p>

                <h3 class="mt-3 text-4xl font-extrabold text-slate-900">
                    {{ $categories->total() }}
                </h3>
            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
                <p class="text-sm font-semibold text-slate-400">
                    Hasil Ditampilkan
                </p>

                <h3 class="mt-3 text-4xl font-extrabold text-slate-900">
                    {{ $categories->count() }}
                </h3>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100">
            <form method="GET" action="{{ route('categories.index') }}" class="flex flex-col md:flex-row gap-3">
                <div class="relative flex-1">
                    <input type="text"
                           name="search"
                           value="{{ $search ?? '' }}"
                           placeholder="Cari nama kategori atau deskripsi..."
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
                    <a href="{{ route('categories.index') }}"
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
                        Daftar Kategori
                    </h3>

                    <p class="text-sm text-slate-400 mt-1">
                        Data kategori yang tersedia di sistem Inventra.
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500 rounded-l-2xl">
                                No
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500">
                                Nama
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500">
                                Deskripsi
                            </th>

                            <th class="px-5 py-4 text-left text-sm font-bold text-slate-500">
                                Jumlah Barang
                            </th>

                            <th class="px-5 py-4 text-right text-sm font-bold text-slate-500 rounded-r-2xl">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="px-5 py-4 text-sm text-slate-500">
                                    {{ $categories->firstItem() + $loop->index }}
                                </td>

                                <td class="px-5 py-4 text-sm">
                                    <a href="{{ route('categories.show', $category) }}"
                                       class="font-extrabold text-slate-900 hover:text-[#FF2C2C] transition">
                                        {{ $category->name }}
                                    </a>
                                </td>

                                <td class="px-5 py-4 text-sm text-slate-500">
                                    {{ $category->description ?? '-' }}
                                </td>

                                <td class="px-5 py-4 text-sm">
                                    <a href="{{ route('categories.show', $category) }}"
                                       class="inline-flex px-3 py-1.5 rounded-full bg-sky-50 text-sky-600 text-xs font-bold hover:bg-sky-100 transition">
                                        {{ $category->products_count }} Barang
                                    </a>
                                </td>

                                <td class="px-5 py-4 text-sm text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('categories.show', $category) }}"
                                           class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200 transition">
                                            Detail
                                        </a>

                                        <a href="{{ route('categories.edit', $category) }}"
                                           class="px-4 py-2 rounded-xl bg-amber-500 text-white text-xs font-bold hover:bg-amber-600 transition">
                                            Edit
                                        </a>

                                        <form action="{{ route('categories.destroy', $category) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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
                                <td colspan="5" class="px-5 py-10 text-center text-slate-400">
                                    Tidak ada data kategori yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($categories->hasPages())
                @php
                    $currentPage = $categories->currentPage();
                    $lastPage = $categories->lastPage();
                    $startPage = max(1, $currentPage - 2);
                    $endPage = min($lastPage, $currentPage + 2);
                @endphp

                <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-slate-500">
                        Menampilkan
                        <span class="font-bold text-slate-700">
                            {{ $categories->firstItem() }}
                        </span>
                        sampai
                        <span class="font-bold text-slate-700">
                            {{ $categories->lastItem() }}
                        </span>
                        dari
                        <span class="font-bold text-slate-700">
                            {{ $categories->total() }}
                        </span>
                        data
                    </p>

                    <div class="flex items-center gap-2">
                        @if ($categories->onFirstPage())
                            <span class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-300 flex items-center justify-center cursor-not-allowed">
                                ‹
                            </span>
                        @else
                            <a href="{{ $categories->previousPageUrl() }}"
                               class="w-10 h-10 rounded-2xl bg-white border border-slate-200 text-slate-600 flex items-center justify-center hover:bg-red-50 hover:text-red-600 hover:border-red-100 transition">
                                ‹
                            </a>
                        @endif

                        @if ($startPage > 1)
                            <a href="{{ $categories->url(1) }}"
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
                                <a href="{{ $categories->url($page) }}"
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

                            <a href="{{ $categories->url($lastPage) }}"
                               class="w-10 h-10 rounded-2xl bg-white border border-slate-200 text-slate-600 text-sm font-bold flex items-center justify-center hover:bg-red-50 hover:text-red-600 hover:border-red-100 transition">
                                {{ $lastPage }}
                            </a>
                        @endif

                        @if ($categories->hasMorePages())
                            <a href="{{ $categories->nextPageUrl() }}"
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
