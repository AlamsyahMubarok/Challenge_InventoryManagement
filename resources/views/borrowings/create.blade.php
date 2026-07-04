<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Peminjaman
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">

                <form action="{{ route('borrowings.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Peminjam</label>
                        <input type="text"
                               name="borrower_name"
                               value="{{ old('borrower_name') }}"
                               placeholder="Kosongkan jika peminjam adalah user login"
                               class="w-full border-gray-300 rounded-md shadow-sm">

                        @error('borrower_name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Barang</label>
                        <select name="product_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">Pilih barang</option>

                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>
                                    {{ $product->code }} - {{ $product->name }} | Stok: {{ $product->stock }}
                                </option>
                            @endforeach
                        </select>

                        @error('product_id')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                        <input type="number"
                               name="quantity"
                               value="{{ old('quantity', 1) }}"
                               min="1"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               required>

                        @error('quantity')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pinjam</label>
                        <input type="date"
                               name="borrow_date"
                               value="{{ old('borrow_date', now()->toDateString()) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               required>

                        @error('borrow_date')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Batas Pengembalian</label>
                        <input type="date"
                               name="due_date"
                               value="{{ old('due_date') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm">

                        @error('due_date')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                        <textarea name="notes"
                                  rows="4"
                                  class="w-full border-gray-300 rounded-md shadow-sm">{{ old('notes') }}</textarea>

                        @error('notes')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('borrowings.index') }}"
                           class="px-4 py-2 bg-gray-200 rounded-md text-sm">
                            Batal
                        </a>

                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
