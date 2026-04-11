<x-guest-layout>
    <!-- isi landing-page -->
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-600 to-indigo-700 text-white">

        <div class="text-center max-w-2xl px-6">

            <h1 class="text-5xl font-bold mb-4">
                SIPALET
            </h1>

            <p class="mb-8 text-lg text-blue-100">
                Platform untuk mengelola produksi pallet, monitoring stok, dan distribusi dalam satu sistem terintegrasi.
            </p>

            <div class="flex justify-center gap-4">
                <a href="{{ route('login') }}"
                    class="px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg shadow hover:bg-gray-200 transition">
                    Mulai Sekarang
                </a>

                <a href="{{ route('register') }}"
                    class="px-6 py-3 border border-white rounded-lg hover:bg-white hover:text-blue-600 transition">
                    Daftar
                </a>
            </div>

        </div>

    </div>

</x-guest-layout>