<x-app-layout>
    <div class="space-y-6">

        <div>
            <p class="text-sm font-semibold text-red-500 mb-2">
                Manajemen Kategori
            </p>

            <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                Edit Kategori
            </h1>

            <p class="mt-2 text-slate-500">
                Perbarui informasi kategori barang yang sudah terdaftar.
            </p>
        </div>

        <div class="max-w-4xl">
            <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-sm border border-slate-100">

                <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            Nama Kategori
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name', $category->name) }}"
                               class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]"
                               required>

                        @error('name')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">
                            Deskripsi
                        </label>

                        <textarea name="description"
                                  rows="5"
                                  class="w-full rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]">{{ old('description', $category->description) }}</textarea>

                        @error('description')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <a href="{{ route('categories.index') }}"
                           class="px-5 py-3 rounded-2xl bg-slate-100 text-slate-700 text-sm font-bold hover:bg-slate-200 transition">
                            Batal
                        </a>

                        <button type="submit"
                                class="px-5 py-3 rounded-2xl bg-[#FF2C2C] text-white text-sm font-bold shadow-sm hover:bg-[#D91F1F] transition">
                            Update
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</x-app-layout>
