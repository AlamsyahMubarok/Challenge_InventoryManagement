<x-app-layout>
    @php
        $conditionClass = function ($condition) {
            return match ($condition) {
                'Baik' => 'bg-green-50 text-green-600',
                'Rusak Ringan' => 'bg-orange-50 text-orange-600',
                'Rusak Berat', 'Rusak Parah' => 'bg-red-50 text-red-600',
                'Maintenance' => 'bg-yellow-50 text-yellow-700',
                default => 'bg-slate-100 text-slate-600',
            };
        };
    @endphp

    <div class="space-y-6">

        <div>
            <p class="text-sm font-semibold text-red-500 mb-2">
                Manajemen Peminjaman
            </p>

            <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                Detail Peminjaman
            </h1>

            <p class="mt-2 text-slate-500">
                Informasi lengkap transaksi peminjaman dan pengembalian barang.
            </p>
        </div>

        @if (session('success'))
            <div class="rounded-2xl bg-green-50 border border-green-100 px-5 py-4 text-green-700 text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-2xl bg-red-50 border border-red-100 px-5 py-4 text-red-700 text-sm font-semibold">
                {{ session('error') }}
            </div>
        @endif

        @if ($borrowing->isOverdue())
            <div class="rounded-2xl bg-red-50 border border-red-100 px-5 py-4 text-red-700 text-sm font-semibold">
                Peminjaman ini sudah melewati batas pengembalian.
            </div>
        @endif

        <div class="max-w-6xl">
            <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-sm border border-slate-100">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="rounded-3xl bg-slate-50 p-5">
                        <p class="text-sm font-semibold text-slate-400">
                            Peminjam
                        </p>

                        <p class="mt-2 text-lg font-extrabold text-slate-900">
                            {{ $borrowing->borrower_name ?? $borrowing->user->name }}
                        </p>
                    </div>

                    <div class="rounded-3xl bg-slate-50 p-5">
                        <p class="text-sm font-semibold text-slate-400">
                            Dibuat Oleh
                        </p>

                        <p class="mt-2 text-lg font-extrabold text-slate-900">
                            {{ $borrowing->user->name }}
                        </p>
                    </div>

                    <div class="rounded-3xl bg-slate-50 p-5">
                        <p class="text-sm font-semibold text-slate-400">
                            Tanggal Pinjam
                        </p>

                        <p class="mt-2 text-lg font-extrabold text-slate-900">
                            {{ $borrowing->borrow_date }}
                        </p>
                    </div>

                    <div class="rounded-3xl bg-slate-50 p-5">
                        <p class="text-sm font-semibold text-slate-400">
                            Batas Pengembalian
                        </p>

                        <p class="mt-2 text-lg font-extrabold text-slate-900">
                            {{ $borrowing->due_date ?? '-' }}
                        </p>
                    </div>

                    <div class="rounded-3xl bg-slate-50 p-5">
                        <p class="text-sm font-semibold text-slate-400">
                            Tanggal Kembali
                        </p>

                        <p class="mt-2 text-lg font-extrabold text-slate-900">
                            {{ $borrowing->return_date ?? '-' }}
                        </p>
                    </div>

                    <div class="rounded-3xl bg-slate-50 p-5">
                        <p class="text-sm font-semibold text-slate-400">
                            Status
                        </p>

                        <span class="inline-flex mt-3 px-3 py-1.5 rounded-full text-xs font-bold {{ $borrowing->status_badge_class }}">
                            {{ $borrowing->status_label }}
                        </span>
                    </div>
                </div>

                <div class="mt-6 rounded-3xl bg-slate-50 p-5">
                    <p class="text-sm font-semibold text-slate-400">
                        Catatan
                    </p>

                    <p class="mt-2 text-sm leading-7 text-slate-700">
                        {{ $borrowing->notes ?? '-' }}
                    </p>
                </div>

            </div>
        </div>

        <div class="max-w-6xl">
            <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-sm border border-slate-100">
                <div class="mb-6">
                    <h3 class="text-xl font-extrabold text-slate-900">
                        Barang Dipinjam
                    </h3>

                    <p class="text-sm text-slate-400 mt-1">
                        Daftar barang yang tercatat dalam transaksi peminjaman ini.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-slate-50">
                                <th class="px-5 py-4 text-left text-sm font-bold text-slate-500 rounded-l-2xl">Kode</th>
                                <th class="px-5 py-4 text-left text-sm font-bold text-slate-500">Nama</th>
                                <th class="px-5 py-4 text-left text-sm font-bold text-slate-500">Jumlah</th>
                                <th class="px-5 py-4 text-left text-sm font-bold text-slate-500">Kondisi Awal</th>
                                <th class="px-5 py-4 text-left text-sm font-bold text-slate-500 rounded-r-2xl">Kondisi Akhir</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @foreach ($borrowing->details as $detail)
                                <tr>
                                    <td class="px-5 py-4 text-sm font-bold text-slate-800">
                                        {{ $detail->product->code }}
                                    </td>

                                    <td class="px-5 py-4 text-sm text-slate-600">
                                        {{ $detail->product->name }}
                                    </td>

                                    <td class="px-5 py-4 text-sm font-bold text-slate-800">
                                        {{ $detail->quantity }}
                                    </td>

                                    <td class="px-5 py-4 text-sm">
                                        <span class="inline-flex whitespace-nowrap px-3 py-1.5 rounded-full text-xs font-bold {{ $conditionClass($detail->condition_before) }}">
                                            {{ $detail->condition_before ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-4 text-sm">
                                        <span class="inline-flex whitespace-nowrap px-3 py-1.5 rounded-full text-xs font-bold {{ $conditionClass($detail->condition_after) }}">
                                            {{ $detail->condition_after ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($borrowing->status === 'borrowed')
            <div class="max-w-6xl">
                <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-sm border border-slate-100">
                    <div class="mb-6">
                        <h3 class="text-xl font-extrabold text-slate-900">
                            Pengembalian Barang
                        </h3>

                        <p class="text-sm text-slate-400 mt-1">
                            Isi kondisi barang setelah dikembalikan.
                        </p>
                    </div>

                    <form action="{{ route('borrowings.return', $borrowing) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Kondisi Setelah Dikembalikan
                            </label>

                            <select name="condition_after"
                                    class="w-full h-12 rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]">
                                <option value="">Pilih kondisi</option>
                                <option value="Baik">Baik</option>
                                <option value="Rusak Ringan">Rusak Ringan</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>

                            @error('condition_after')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Catatan Pengembalian
                            </label>

                            <textarea name="return_notes"
                                      rows="4"
                                      placeholder="Tambahkan catatan pengembalian jika diperlukan..."
                                      class="w-full rounded-2xl border-slate-200 text-sm focus:border-[#FF2C2C] focus:ring-[#FF2C2C]"></textarea>

                            @error('return_notes')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                    onclick="return confirm('Konfirmasi pengembalian barang?')"
                                    class="px-5 py-3 rounded-2xl bg-green-600 text-white text-sm font-bold shadow-sm hover:bg-green-700 transition">
                                Proses Pengembalian
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <div class="max-w-6xl flex justify-end">
            <a href="{{ route('borrowings.index') }}"
               class="px-5 py-3 rounded-2xl bg-slate-100 text-slate-700 text-sm font-bold hover:bg-slate-200 transition">
                Kembali
            </a>
        </div>

    </div>
</x-app-layout>
