<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Barang
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Kode Barang</p>
                        <p class="font-semibold">{{ $product->code }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Nama Barang</p>
                        <p class="font-semibold">{{ $product->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Kategori</p>
                        <p class="font-semibold">{{ $product->category->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Stok</p>
                        <p class="font-semibold">{{ $product->stock }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Lokasi</p>
                        <p class="font-semibold">{{ $product->location }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Kondisi</p>
                        <p class="font-semibold">{{ $product->condition }}</p>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <a href="{{ route('products.index') }}"
                       class="px-4 py-2 bg-gray-200 rounded-md text-sm">
                        Kembali
                    </a>

                    <a href="{{ route('products.edit', $product) }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                        Edit
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
