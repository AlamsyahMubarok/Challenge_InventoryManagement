<x-app-layout>
    <div class="space-y-6">

        <div>
            <p class="text-sm font-semibold text-red-500 mb-2">
                Manajemen Barang
            </p>

            <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">
                Tambah Barang
            </h1>

            <p class="mt-2 text-slate-500">
                Tambahkan barang baru ke dalam data inventaris.
            </p>
        </div>

        <div class="max-w-5xl">
            <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-sm border border-slate-100">
                <form action="{{ route('products.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-6">
                    @csrf

                    @include('products._form')

                    <div class="flex justify-end gap-3 pt-2">
                        <a href="{{ route('products.index') }}"
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
