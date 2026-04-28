<section>
    <header class="mb-6">
        <h2 class="text-xl font-black text-slate-800 dark:text-white flex items-center">
            <span class="bg-slate-100 p-2 rounded-lg mr-3">🔒</span>
            {{ __('Keamanan Sandi') }}
        </h2>
        <p class="mt-2 text-sm text-slate-500">
            {{ __('Gunakan sandi yang kuat dan unik agar akun Anda tetap terlindungi.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="space-y-4">
            <div>
                <x-input-label for="update_password_current_password" :value="__('Sandi Saat Ini')" class="font-bold" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-2 block w-full rounded-xl border-slate-200" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="update_password_password" :value="__('Sandi Baru')" class="font-bold" />
                    <x-text-input id="update_password_password" name="password" type="password" class="mt-2 block w-full rounded-xl border-slate-200" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Sandi Baru')" class="font-bold" />
                    <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-2 block w-full rounded-xl border-slate-200" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t">
            <x-primary-button class="rounded-xl px-8 py-3 bg-slate-800 hover:bg-black transition-all">
                {{ __('Perbarui Sandi') }}
            </x-primary-button>
        </div>
    </form>
</section>