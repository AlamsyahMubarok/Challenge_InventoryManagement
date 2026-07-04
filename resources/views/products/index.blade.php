<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Barang
            </h2>

            <a href="{{ route('products.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                Tambah Barang
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
                <form method="GET" action="{{ route('products.index') }}" class="flex gap-2">
                    <input type="text"
                           name="search"
                           value="{{ $search }}"
                           placeholder="Cari kode, nama, lokasi, atau kondisi..."
                           class="w-full border-gray-300 rounded-md shadow-sm">

                    <button type="submit"
                            class="px-4 py-2 bg-gray-800 text-white rounded-md text-sm">
                        Cari
                    </button>

                    @if ($search)
                        <a href="{{ route('products.index') }}"
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
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Kode</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Kategori</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Stok</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Lokasi</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Kondisi</th>
                            <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @forelse ($products as $product)
                            <tr>
                                <td class="px-6 py-4 text-sm">
                                    {{ $products->firstItem() + $loop->index }}
                                </td>

                                <td class="px-6 py-4 text-sm font-medium">
                                    {{ $product->code }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    {{ $product->name }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    {{ $product->category->name }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    {{ $product->stock }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    {{ $product->location }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    {{ $product->condition }}
                                </td>

                                <td class="px-6 py-4 text-sm text-right">
                                    <a href="{{ route('products.show', $product) }}"
                                       class="text-gray-700 hover:underline">
                                        Detail
                                    </a>

                                    <a href="{{ route('products.edit', $product) }}"
                                       class="ml-3 text-blue-600 hover:underline">
                                        Edit
                                    </a>

                                    <form action="{{ route('products.destroy', $product) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="ml-3 text-red-600 hover:underline">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada data barang.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
