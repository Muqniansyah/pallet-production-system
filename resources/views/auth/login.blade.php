<x-guest-layout>

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-600 to-indigo-700">

        <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">

            <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">
                Masuk ke SIPALET
            </h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full"
                        type="email" name="email"
                        :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full"
                        type="password" name="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember -->
                <div class="flex items-center justify-between mt-4">
                    <label class="flex items-center text-sm text-gray-600">
                        <input type="checkbox" name="remember"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm">
                        <span class="ml-2">Ingat saya</span>
                    </label>

                    @if (Route::has('password.request'))
                    <a class="text-sm text-blue-500 hover:underline"
                        href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                    @endif
                </div>

                <!-- Button -->
                <div class="mt-6">
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                        Masuk
                    </button>
                </div>

            </form>

            <!-- Register Link -->
            <p class="text-center text-sm text-gray-600 mt-6">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-500 hover:underline">
                    Daftar
                </a>
            </p>

        </div>

    </div>

</x-guest-layout>