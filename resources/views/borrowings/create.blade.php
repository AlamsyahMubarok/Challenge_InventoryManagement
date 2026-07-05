<x-app-layout>
    <div class="space-y-6">

        <div>
            <p class="text-sm font-semibold text-red-500 mb-2">
                Manajemen Peminjaman
            </p>

            <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                Tambah Peminjaman
            </h1>

            <p class="mt-2 text-slate-500">
                Buat transaksi peminjaman barang dan sistem akan mengurangi stok secara otomatis.
            </p>
        </div>

        <div class="max-w-5xl">
            <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-sm border border-slate-100">

                <form action="{{ route('borrowings.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Nama Peminjam
                            </label>

                            <input type="text"
                                   name="borrower_name"
                                   value="{{ old('borrower_name') }}"
                                   placeholder="Kosongkan jika peminjam adalah user login"
                                   class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]">

                            @error('borrower_name')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Barang
                            </label>

                            <select name="product_id"
                                    class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]"
                                    required>
                                <option value="">Pilih barang</option>

                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>
                                        {{ $product->code }} - {{ $product->name }} | Stok: {{ $product->stock }}
                                    </option>
                                @endforeach
                            </select>

                            @error('product_id')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Jumlah
                            </label>

                            <input type="number"
                                   name="quantity"
                                   value="{{ old('quantity', 1) }}"
                                   min="1"
                                   class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]"
                                   required>

                            @error('quantity')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Tanggal Pinjam
                            </label>

                            <input type="date"
                                   name="borrow_date"
                                   value="{{ old('borrow_date', now()->toDateString()) }}"
                                   class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]"
                                   required>

                            @error('borrow_date')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Batas Pengembalian
                            </label>

                            <input type="date"
                                   name="due_date"
                                   value="{{ old('due_date') }}"
                                   class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]">

                            @error('due_date')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            Catatan
                        </label>

                        <textarea name="notes"
                                  rows="5"
                                  placeholder="Tambahkan catatan peminjaman jika diperlukan..."
                                  class="w-full rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]">{{ old('notes') }}</textarea>

                        @error('notes')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <a href="{{ route('borrowings.index') }}"
                           class="px-5 py-3 rounded-2xl bg-slate-100 text-slate-700 text-sm font-bold hover:bg-slate-200 transition">
                            Batal
                        </a>

                        <button type="submit"
                                class="px-5 py-3 rounded-2xl bg-[#FF2C2C] text-white text-sm font-bold shadow-sm hover:bg-[#D91F1F] transition">
                            Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</x-app-layout>
