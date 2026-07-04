<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>

    <select name="category_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
        <option value="">Pilih kategori</option>

        @foreach ($categories as $category)
            <option value="{{ $category->id }}"
                @selected(old('category_id', $product->category_id ?? '') == $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>

    @error('category_id')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Barang</label>

    <input type="text"
           name="code"
           value="{{ old('code', $product->code ?? '') }}"
           class="w-full border-gray-300 rounded-md shadow-sm"
           required>

    @error('code')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>

    <input type="text"
           name="name"
           value="{{ old('name', $product->name ?? '') }}"
           class="w-full border-gray-300 rounded-md shadow-sm"
           required>

    @error('name')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>

    <input type="number"
           name="stock"
           value="{{ old('stock', $product->stock ?? 0) }}"
           min="0"
           class="w-full border-gray-300 rounded-md shadow-sm"
           required>

    @error('stock')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>

    <input type="text"
           name="location"
           value="{{ old('location', $product->location ?? '') }}"
           class="w-full border-gray-300 rounded-md shadow-sm"
           required>

    @error('location')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi</label>

    <select name="condition" class="w-full border-gray-300 rounded-md shadow-sm" required>
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
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>
