<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-40">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- kiri: logo & brand -->
            <div class="flex items-center">
                <!-- Tombol hamburger mobile -->
                <button @click="$store.sidebar.open = !$store.sidebar.open"
                        class="md:hidden ml-3 p-2 rounded-lg text-slate-500 hover:bg-gray-100">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <!-- nama aplikasi & tagline -->
                <div class="flex items-center space-x-3">
                    <h1 class="text-xl font-black text-slate-800 leading-none tracking-tighter italic">
                        SI<span class="text-slate-400 font-light uppercase">PALET</span>
                    </h1>

                    <div class="hidden sm:block h-5 w-[1px] bg-slate-200"></div>

                    <span class="hidden sm:block text-[10px] font-medium text-slate-400 uppercase tracking-[0.15em] leading-none">
                        Solusi Kayu Berkualitas
                    </span>
                </div>
            </div>

            <!-- kanan: informasi pengguna -->
            <div class="flex sm:items-center sm:ms-6">
                <div class="flex items-center space-x-4">
                    <!-- Dropdown akun pengguna -->
                    <x-dropdown align="right" width="48">
                        <!-- Tombol dropdown -->
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-1 border border-gray-200 text-sm leading-4 font-bold rounded-full text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                                <div class="h-7 w-7 rounded-full flex items-center justify-center mr-2 {{ request()->is('admin/*') ? 'bg-blue-600' : 'bg-emerald-600' }} text-white text-[10px]">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>

                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <!-- Menu dropdown -->
                        <x-slot name="content">
                            <!-- Judul -->
                            <div class="block px-4 py-2 text-xs text-gray-400 uppercase tracking-widest font-bold border-b border-gray-100">
                                Kelola Akun
                            </div>

                            <!-- Akses profil pengguna -->
                            <x-dropdown-link :href="route('profile.edit')" class="hover:bg-gray-50">
                                {{ __('Profil Saya') }}
                            </x-dropdown-link>

                            <!-- Form logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    class="text-red-600 hover:bg-red-50"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Keluar') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </div>
</nav>
