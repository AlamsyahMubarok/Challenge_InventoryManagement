<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-bold text-slate-700 mb-2">
            Kategori
        </label>

        <select name="category_id"
                class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]"
                required>
            <option value="">Pilih kategori</option>

            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    @selected(old('category_id', $product->category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        @error('category_id')
            <p class="text-sm text-red-600 mt-2 font-semibold">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-bold text-slate-700 mb-2">
            Kode Barang
        </label>

        <input type="text"
               name="code"
               value="{{ old('code', $product->code ?? '') }}"
               placeholder="Contoh: BRG-ELK-001"
               class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]"
               required>

        @error('code')
            <p class="text-sm text-red-600 mt-2 font-semibold">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-bold text-slate-700 mb-2">
            Nama Barang
        </label>

        <input type="text"
               name="name"
               value="{{ old('name', $product->name ?? '') }}"
               placeholder="Masukkan nama barang"
               class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]"
               required>

        @error('name')
            <p class="text-sm text-red-600 mt-2 font-semibold">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-bold text-slate-700 mb-2">
            Kondisi Utama
        </label>

        <select name="condition"
                class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]"
                required>
            @php
                $conditions = ['Baik', 'Rusak Ringan', 'Rusak Berat', 'Maintenance'];
            @endphp

            <option value="">Pilih kondisi</option>

            @foreach ($conditions as $condition)
                <option value="{{ $condition }}"
                    @selected(old('condition', $product->condition ?? '') == $condition)>
                    {{ $condition }}
                </option>
            @endforeach
        </select>

        @error('condition')
            <p class="text-sm text-red-600 mt-2 font-semibold">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-bold text-slate-700 mb-2">
            Stok Siap Dipinjam
        </label>

        <input type="number"
               name="stock"
               value="{{ old('stock', $product->stock ?? 0) }}"
               min="0"
               class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]"
               required>

        @error('stock')
            <p class="text-sm text-red-600 mt-2 font-semibold">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-bold text-slate-700 mb-2">
            Batas Stok Menipis
        </label>

        <input type="number"
               name="minimum_stock"
               value="{{ old('minimum_stock', $product->minimum_stock ?? 5) }}"
               min="0"
               class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]"
               required>

        @error('minimum_stock')
            <p class="text-sm text-red-600 mt-2 font-semibold">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-bold text-slate-700 mb-2">
            Rusak Ringan
        </label>

        <input type="number"
               name="light_damage_stock"
               value="{{ old('light_damage_stock', $product->light_damage_stock ?? 0) }}"
               min="0"
               class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]"
               required>

        @error('light_damage_stock')
            <p class="text-sm text-red-600 mt-2 font-semibold">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-bold text-slate-700 mb-2">
            Rusak Berat
        </label>

        <input type="number"
               name="heavy_damage_stock"
               value="{{ old('heavy_damage_stock', $product->heavy_damage_stock ?? 0) }}"
               min="0"
               class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]"
               required>

        @error('heavy_damage_stock')
            <p class="text-sm text-red-600 mt-2 font-semibold">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-bold text-slate-700 mb-2">
            Maintenance
        </label>

        <input type="number"
               name="maintenance_stock"
               value="{{ old('maintenance_stock', $product->maintenance_stock ?? 0) }}"
               min="0"
               class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]"
               required>

        @error('maintenance_stock')
            <p class="text-sm text-red-600 mt-2 font-semibold">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-bold text-slate-700 mb-2">
            Lokasi
        </label>

        <input type="text"
               name="location"
               value="{{ old('location', $product->location ?? '') }}"
               placeholder="Contoh: Ruang IT"
               class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]"
               required>

        @error('location')
            <p class="text-sm text-red-600 mt-2 font-semibold">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-bold text-slate-700 mb-2">
            Deskripsi Barang
        </label>

        <textarea name="description"
                  rows="4"
                  placeholder="Contoh: Barang digunakan untuk operasional ruang IT. Satu unit mengalami kerusakan layar."
                  class="w-full rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]">{{ old('description', $product->description ?? '') }}</textarea>

        @error('description')
            <p class="text-sm text-red-600 mt-2 font-semibold">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-bold text-slate-700 mb-2">
            Gambar Barang
        </label>

        <div class="rounded-3xl border border-slate-100 bg-slate-50 p-5">
            @isset($product)
                @if ($product->image_url)
                    <div class="mb-5">
                        <p class="mb-3 text-sm font-semibold text-slate-500">
                            Gambar saat ini
                        </p>

                        <img src="{{ $product->image_url }}"
                             alt="{{ $product->name }}"
                             class="w-40 h-40 rounded-3xl object-cover border border-slate-100 bg-white">
                    </div>
                @endif
            @endisset

            <input type="file"
                   name="image"
                   accept="image/jpeg,image/png,image/jpg,image/webp"
                   class="block w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-5 file:rounded-2xl file:border-0 file:text-sm file:font-bold file:bg-red-50 file:text-red-600 hover:file:bg-red-100">

            <p class="mt-3 text-xs font-semibold text-slate-400">
                Format yang didukung: JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
            </p>

            @error('image')
                <p class="text-sm text-red-600 mt-2 font-semibold">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
</div>
