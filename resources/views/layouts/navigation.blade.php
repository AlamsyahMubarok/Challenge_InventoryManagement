@php
    $role = Auth::user()->role?->name;
    $canManageInventory = in_array($role, ['admin', 'staff']);
    $canViewReports = in_array($role, ['admin', 'manager']);

    $menuItems = [
        [
            'label' => 'Dashboard',
            'route' => route('dashboard'),
            'active' => request()->routeIs('dashboard'),
            'icon' => 'dashboard.png',
            'show' => true,
        ],
        [
            'label' => 'Kategori',
            'route' => route('categories.index'),
            'active' => request()->routeIs('categories.*'),
            'icon' => 'kategori.png',
            'show' => $canManageInventory,
        ],
        [
            'label' => 'Barang',
            'route' => route('products.index'),
            'active' => request()->routeIs('products.*'),
            'icon' => 'barang.png',
            'show' => $canManageInventory,
        ],
        [
            'label' => 'Peminjaman',
            'route' => route('borrowings.index'),
            'active' => request()->routeIs('borrowings.*'),
            'icon' => 'peminjaman.png',
            'show' => $canManageInventory,
        ],
        [
            'label' => 'Laporan',
            'route' => route('reports.index'),
            'active' => request()->routeIs('reports.*'),
            'icon' => 'laporan.png',
            'show' => $canViewReports,
        ],
    ];
@endphp

<div x-data="{ sidebarOpen: false, profileOpen: false }">
    <div class="lg:hidden fixed top-0 left-0 right-0 z-40 h-16 bg-white border-b border-slate-200 px-4 flex items-center justify-between">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/inventra-icon.png') }}?v=50"
                 alt="Inventra"
                 class="w-10 h-10 object-contain">
            <span class="font-extrabold text-lg text-red-600">Inventra</span>
        </a>

        <button type="button"
                @click="sidebarOpen = true"
                class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16" />
            </svg>
        </button>
    </div>

    <div x-show="sidebarOpen"
         x-cloak
         class="lg:hidden fixed inset-0 z-40 bg-black/40"
         @click="sidebarOpen = false"></div>

    <aside class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-slate-200 shadow-sm transform transition-transform duration-200 lg:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

        <div class="h-full flex flex-col">
            <div class="px-6 pt-6 pb-5">
                <div class="flex items-center justify-between">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/inventra-icon.png') }}?v=50"
                             alt="Inventra"
                             class="w-12 h-12 object-contain">

                        <div>
                            <div class="text-xl font-extrabold text-red-600 leading-none">
                                Inventra
                            </div>
                            <div class="text-xs text-slate-400 mt-1">
                                Inventory System
                            </div>
                        </div>
                    </a>

                    <button type="button"
                            @click="sidebarOpen = false"
                            class="lg:hidden w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 8.586l4.95-4.95a1 1 0 111.414 1.414L11.414 10l4.95 4.95a1 1 0 01-1.414 1.414L10 11.414l-4.95 4.95a1 1 0 01-1.414-1.414L8.586 10l-4.95-4.95A1 1 0 015.05 3.636L10 8.586z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            <nav class="flex-1 px-4 py-2 space-y-2">
                @foreach ($menuItems as $item)
                    @if ($item['show'])
                        <a href="{{ $item['route'] }}"
                           class="group flex items-center gap-4 px-4 py-3 rounded-2xl transition
                           {{ $item['active']
                                ? 'bg-red-50 text-red-600 shadow-sm'
                                : 'text-slate-500 hover:bg-slate-50 hover:text-red-600' }}">
                            <span class="w-11 h-11 rounded-2xl flex items-center justify-center
                                {{ $item['active'] ? 'bg-white' : 'bg-slate-100 group-hover:bg-white' }}">
                                <img src="{{ asset('images/' . $item['icon']) }}?v=50"
                                     alt="{{ $item['label'] }}"
                                     class="w-7 h-7 object-contain">
                            </span>

                            <span class="font-semibold text-sm">
                                {{ $item['label'] }}
                            </span>
                        </a>
                    @endif
                @endforeach
            </nav>

            <div class="px-4 pb-5">
                <div class="relative">
                    <button type="button"
                            @click="profileOpen = !profileOpen"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl bg-slate-50 hover:bg-slate-100 transition">
                        <img src="{{ asset('images/profil.png') }}?v=50"
                             alt="Profil"
                             class="w-11 h-11 rounded-full object-contain">

                        <div class="flex-1 text-left min-w-0">
                            <div class="font-bold text-sm text-slate-800 truncate">
                                {{ Auth::user()->name }}
                            </div>
                            <div class="text-xs text-slate-400 truncate">
                                {{ ucfirst($role ?? 'user') }}
                            </div>
                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-4 h-4 text-slate-400"
                             viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="profileOpen"
                         x-cloak
                         @click.outside="profileOpen = false"
                         class="absolute bottom-full left-0 right-0 mb-3 bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
                        <a href="{{ route('profile.edit') }}"
                           class="block px-4 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                            Profil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit"
                                    class="w-full text-left px-4 py-3 text-sm font-semibold text-red-600 hover:bg-red-50">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <div class="lg:hidden h-16"></div>
</div>
