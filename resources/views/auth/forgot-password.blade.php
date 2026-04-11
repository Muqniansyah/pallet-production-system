<x-guest-layout>

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-600 to-indigo-700">

        <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">

            <h2 class="text-2xl font-bold text-center mb-4 text-gray-800">
                Lupa Password
            </h2>

            <p class="text-sm text-gray-600 text-center mb-6">
                Masukkan email kamu, kami akan kirim link untuk reset password.
            </p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full"
                        type="email" name="email"
                        :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Button -->
                <div class="mt-6">
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                        Kirim Link Reset
                    </button>
                </div>

            </form>

            <!-- Back to login -->
            <p class="text-center text-sm text-gray-600 mt-6">
                Ingat password?
                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">
                    Masuk
                </a>
            </p>

        </div>

    </div>

</x-guest-layout>