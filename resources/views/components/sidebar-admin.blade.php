<div class="w-64 min-h-[calc(100vh-64px)] bg-gray-800 text-white p-5">
    <h2 class="text-xl font-bold mb-6">Admin Panel</h2>

    <ul class="space-y-3">
        <li>
            <a href="/admin/dashboard"
                class="block {{ request()->is('admin/dashboard') ? 'text-blue-400 font-bold' : '' }}">
                Dashboard
            </a>
        </li>
        <li>
            <a href="/admin/pallet"
                class="block {{ request()->is('admin/pallet') ? 'text-blue-400 font-bold' : '' }}">
                Kelola Pallet
            </a>
        </li>
        <li>
            <a href="/admin/client"
                class="block {{ request()->is('admin/client') ? 'text-blue-400 font-bold' : '' }}">
                Data Client
            </a>
        </li>
    </ul>
</div>