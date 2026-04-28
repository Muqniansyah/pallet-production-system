<section class="space-y-6">
    <header class="flex items-start">
        <div class="bg-rose-100 dark:bg-rose-900/50 p-3 rounded-2xl mr-4">
            <svg class="h-6 w-6 text-rose-600 dark:text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </div>
        <div>
            <h2 class="text-lg font-black text-rose-900 dark:text-rose-400 uppercase tracking-tight">
                {{ __('Hapus Akun') }}
            </h2>
            <p class="mt-1 text-sm text-rose-700/70 dark:text-rose-300/60 leading-relaxed">
                {{ __('Tindakan ini permanen. Seluruh data produksi dan riwayat Anda akan dihapus dari server kami selamanya.') }}
            </p>
        </div>
    </header>

    <div class="pt-2">
        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="px-6 py-3 rounded-xl bg-rose-600 hover:bg-rose-700 transition-all shadow-lg shadow-rose-200 dark:shadow-none font-bold uppercase text-[10px] tracking-widest">
            {{ __('Hapus Akun Saya') }}
        </x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-xl font-black text-slate-800 dark:text-white">
                {{ __('Apakah Anda benar-benar yakin?') }}
            </h2>

            <p class="mt-3 text-sm text-slate-500 leading-relaxed">
                {{ __('Untuk melanjutkan, silakan masukkan kata sandi Anda. Ini adalah langkah keamanan terakhir untuk melindungi data Anda.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full border-slate-200 rounded-xl focus:ring-rose-500 focus:border-rose-500"
                    placeholder="{{ __('Masukkan sandi konfirmasi...') }}" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end space-x-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="rounded-xl px-6 border-slate-200 text-slate-600 hover:bg-slate-50">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="rounded-xl px-6 bg-rose-600 hover:bg-rose-700 shadow-lg shadow-rose-200 dark:shadow-none">
                    {{ __('Konfirmasi Hapus') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>