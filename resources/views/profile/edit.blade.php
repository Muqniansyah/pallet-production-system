<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto mb-8">
            <h2 class="text-2xl font-black text-slate-800 dark:text-white tracking-tight">
                {{ __('Pengaturan Akun') }}
            </h2>
            <p class="text-sm text-slate-500 mt-1">Kelola informasi profil, keamanan sandi, dan privasi akun Anda.</p>
        </div>

        <div class="max-w-7xl mx-auto space-y-8">
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm border border-slate-100 dark:border-slate-800 sm:rounded-3xl transition-all duration-300">
                <div class="p-6 sm:p-10">
                    <div class="max-w-2xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm border border-slate-100 dark:border-slate-800 sm:rounded-3xl transition-all duration-300">
                <div class="p-6 sm:p-10">
                    <div class="max-w-2xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="bg-rose-50/50 dark:bg-rose-950/20 overflow-hidden border border-rose-100 dark:border-rose-900/30 sm:rounded-3xl transition-all duration-300">
                <div class="p-6 sm:p-10">
                    <div class="max-w-2xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('status'))
    <div x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 4000)"
        x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed bottom-5 right-5 z-[100] max-w-sm w-full bg-white dark:bg-slate-800 shadow-2xl rounded-2xl border-l-4 border-slate-800 dark:border-slate-500 p-4 flex items-center">
        <div class="flex-shrink-0 bg-slate-100 dark:bg-slate-700 p-2 rounded-xl">
            <svg class="h-5 w-5 text-slate-800 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm font-bold text-slate-800 dark:text-white">Berhasil!</p>
            <p class="text-xs text-slate-500 dark:text-slate-400">{{ session('status') }}</p>
        </div>
        <button @click="show = false" class="ml-auto text-slate-400 hover:text-slate-600">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path d="M6 18L18 6M6 6l12 12" stroke-width="2" />
            </svg>
        </button>
    </div>
    @endif
</x-app-layout>