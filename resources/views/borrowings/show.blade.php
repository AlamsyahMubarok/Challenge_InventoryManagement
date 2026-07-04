<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Peminjaman
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

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

            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Peminjam</p>
                        <p class="font-semibold">{{ $borrowing->borrower_name ?? $borrowing->user->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Dibuat Oleh</p>
                        <p class="font-semibold">{{ $borrowing->user->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Tanggal Pinjam</p>
                        <p class="font-semibold">{{ $borrowing->borrow_date }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Batas Pengembalian</p>
                        <p class="font-semibold">{{ $borrowing->due_date ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Tanggal Kembali</p>
                        <p class="font-semibold">{{ $borrowing->return_date ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <p class="font-semibold">
                            {{ $borrowing->status === 'borrowed' ? 'Dipinjam' : 'Dikembalikan' }}
                        </p>
                    </div>
                </div>

                <div class="mt-4">
                    <p class="text-sm text-gray-500">Catatan</p>
                    <p>{{ $borrowing->notes ?? '-' }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h3 class="font-semibold text-lg mb-4">Barang Dipinjam</h3>

                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm">Kode</th>
                            <th class="px-4 py-2 text-left text-sm">Nama</th>
                            <th class="px-4 py-2 text-left text-sm">Jumlah</th>
                            <th class="px-4 py-2 text-left text-sm">Kondisi Awal</th>
                            <th class="px-4 py-2 text-left text-sm">Kondisi Akhir</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @foreach ($borrowing->details as $detail)
                            <tr>
                                <td class="px-4 py-2 text-sm">{{ $detail->product->code }}</td>
                                <td class="px-4 py-2 text-sm">{{ $detail->product->name }}</td>
                                <td class="px-4 py-2 text-sm">{{ $detail->quantity }}</td>
                                <td class="px-4 py-2 text-sm">{{ $detail->condition_before ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm">{{ $detail->condition_after ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($borrowing->status === 'borrowed')
                <div class="bg-white p-6 rounded-lg shadow mb-6">
                    <h3 class="font-semibold text-lg mb-4">Pengembalian Barang</h3>

                    <form action="{{ route('borrowings.return', $borrowing) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi Setelah Dikembalikan</label>

                            <select name="condition_after" class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Pilih kondisi</option>
                                <option value="Baik">Baik</option>
                                <option value="Rusak Ringan">Rusak Ringan</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Pengembalian</label>
                            <textarea name="return_notes"
                                      rows="3"
                                      class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                    onclick="return confirm('Konfirmasi pengembalian barang?')"
                                    class="px-4 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700">
                                Proses Pengembalian
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <div class="flex justify-end">
                <a href="{{ route('borrowings.index') }}"
                   class="px-4 py-2 bg-gray-200 rounded-md text-sm">
                    Kembali
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
