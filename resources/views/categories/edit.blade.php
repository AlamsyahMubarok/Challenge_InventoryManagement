<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Kategori
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">

                <form action="{{ route('categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Kategori
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name', $category->name) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm"
                               required>

                        @error('name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Deskripsi
                        </label>

                        <textarea name="description"
                                  rows="4"
                                  class="w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $category->description) }}</textarea>

                        @error('description')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('categories.index') }}"
                           class="px-4 py-2 bg-gray-200 rounded-md text-sm">
                            Batal
                        </a>

                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                            Update
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
