<section>
    <header class="mb-6">
        <h2 class="text-xl font-black text-slate-800 dark:text-white flex items-center">
            <span class="bg-slate-100 p-2 rounded-lg mr-3">👤</span>
            {{ __('Informasi Profil') }}
        </h2>
        <p class="mt-2 text-sm text-slate-500">
            {{ __("Perbarui detail akun dan alamat email Anda untuk memastikan informasi tetap akurat.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" class="text-slate-700 font-bold" />
                <x-text-input id="name" name="name" type="text" class="mt-2 block w-full rounded-xl border-slate-200 focus:ring-slate-500" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Alamat Email')" class="text-slate-700 font-bold" />
                <x-text-input id="email" name="email" type="email" class="mt-2 block w-full rounded-xl border-slate-200 focus:ring-slate-500" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div class="p-4 bg-amber-50 rounded-2xl border border-amber-100">
            <p class="text-sm text-amber-800">
                {{ __('Email Anda belum diverifikasi.') }}
                <button form="send-verification" class="underline font-bold hover:text-amber-900 ml-2">
                    {{ __('Klik di sini untuk kirim ulang verifikasi.') }}
                </button>
            </p>
        </div>
        @endif

        <div class="flex items-center gap-4 pt-4 border-t">
            <x-primary-button class="rounded-xl px-8 py-3 bg-slate-800 hover:bg-black transition-all">
                {{ __('Simpan Perubahan') }}
            </x-primary-button>
        </div>
    </form>
</section>