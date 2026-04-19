<div class="w-64 min-h-[calc(100vh-64px)] bg-gray-800 text-white p-5">
    <h2 class="text-xl font-bold mb-6">Client Panel</h2>

    <ul class="space-y-3">
        <li>
            <a href="/client/dashboard"
                class="block {{ request()->is('client/dashboard') ? 'text-green-400 font-bold' : '' }}">
                Dashboard
            </a>
        </li>
        <li>
            <a href="/client/request"
                class="block {{ request()->is('client/request') ? 'text-green-400 font-bold' : '' }}">
                Request Desain
            </a>
        </li>
        <li>
            <a href="#" class="block hover:text-green-400">
                Riwayat
            </a>
        </li>
    </ul>
</div>