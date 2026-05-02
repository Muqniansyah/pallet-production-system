<div x-data="{ open: true }" class="flex min-h-screen">
    <div :class="open ? 'w-72' : 'w-20'" class="bg-[#064e3b] text-emerald-100 p-5 transition-all duration-300 ease-in-out relative flex flex-col shadow-none border-none outline-none">

        <button @click="open = !open" class="absolute -right-3 top-10 bg-emerald-500 text-white rounded-full p-1 shadow-lg hover:bg-emerald-600 transition-colors z-50 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" :class="open ? 'rotate-0' : 'rotate-180'" class="h-4 w-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <div class="flex items-center mb-10 overflow-hidden px-1">
            <div class="h-10 w-10 flex-shrink-0 bg-gradient-to-tr from-emerald-400 to-teal-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                <span class="text-white font-black text-xl">K</span>
            </div>
            <h2 x-show="open" x-transition.opacity class="ml-4 text-xl font-black tracking-tighter text-white italic truncate uppercase">KLIEN PANEL</h2>
        </div>

        <nav class="flex-1 space-y-2">
            @php
            $clientMenus = [
            ['route' => 'client/dashboard', 'label' => 'Beranda', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
            ['route' => 'client/referensi', 'label' => 'Referensi Produk', 'icon' => 'M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z'],
            ['route' => 'client/pallet-request', 'label' => 'Pengajuan & Desain Palet', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
            ['route' => 'client/orders', 'label' => 'Pesanan Saya', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
            ['route' => 'client/meet', 'label' => 'Ajukan Pertemuan', 'icon' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z'],
            ['route' => 'client/informasi', 'label' => 'Pusat Informasi', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ];
            @endphp

            @foreach($clientMenus as $menu)
            <a href="/{{ $menu['route'] }}"
                class="group flex items-center p-3 rounded-xl transition-all duration-200 
                   {{ request()->is($menu['route']) ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/40' : 'hover:bg-emerald-900/50 hover:text-white' }}">

                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 {{ request()->is($menu['route']) ? 'text-white' : 'text-emerald-300 group-hover:text-emerald-100' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $menu['icon'] }}" />
                    </svg>
                </div>

                <span x-show="open" x-transition.opacity class="ml-4 font-bold text-sm tracking-wide whitespace-nowrap">
                    {{ $menu['label'] }}
                </span>

                <div x-show="!open" class="absolute left-20 bg-emerald-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-[60]">
                    {{ $menu['label'] }}
                </div>
            </a>
            @endforeach
        </nav>

        <div class="pt-5 border-t border-emerald-800/50 mt-5">
            <div class="flex items-center overflow-hidden px-1">
                <div class="h-8 w-8 rounded-full bg-emerald-700 flex-shrink-0 border-2 border-emerald-500 flex items-center justify-center text-[10px] font-bold text-white uppercase">
                    {{ substr(auth()->user()->name ?? 'C', 0, 1) }}
                </div>
                <div x-show="open" x-transition.opacity class="ml-3 truncate">
                    <p class="text-xs font-bold text-white leading-none truncate">{{ auth()->user()->name ?? 'Client Name' }}</p>
                    <p class="text-[9px] text-emerald-400 mt-1 uppercase tracking-tighter">Verified Client</p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex-1 bg-white">
        <main class="p-8">
            {{ $slot ?? '' }}
        </main>
    </div>
</div>