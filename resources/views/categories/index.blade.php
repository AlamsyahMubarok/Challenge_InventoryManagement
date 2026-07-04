<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Kategori
            </h2>

            <a href="{{ route('categories.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                Tambah Kategori
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

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">No</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jumlah Barang</th>
                            <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @forelse ($categories as $category)
                            <tr>
                                <td class="px-6 py-4 text-sm">
                                    {{ $categories->firstItem() + $loop->index }}
                                </td>

                                <td class="px-6 py-4 text-sm font-medium">
                                    {{ $category->name }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $category->description ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    {{ $category->products_count }}
                                </td>

                                <td class="px-6 py-4 text-sm text-right">
                                    <a href="{{ route('categories.edit', $category) }}"
                                       class="text-blue-600 hover:underline">
                                        Edit
                                    </a>

                                    <form action="{{ route('categories.destroy', $category) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada data kategori.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $categories->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
