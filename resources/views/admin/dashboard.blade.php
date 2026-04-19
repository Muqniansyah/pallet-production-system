<x-app-layout>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Title -->
            <h2 class="text-2xl font-bold mb-6">Dashboard Admin</h2>

            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Card 1 -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-gray-500 text-sm">Total Produksi</h3>
                    <p class="text-2xl font-bold">1200</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-gray-500 text-sm">Stok Pallet</h3>
                    <p class="text-2xl font-bold">530</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-gray-500 text-sm">Client Aktif</h3>
                    <p class="text-2xl font-bold">25</p>
                </div>

            </div>

            <!-- Table -->
            <div class="mt-8 bg-white p-6 rounded-xl shadow">
                <h3 class="text-lg font-semibold mb-4">Aktivitas Terbaru</h3>

                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Tanggal</th>
                            <th>Kegiatan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="py-2">10 Apr 2026</td>
                            <td>Produksi Pallet</td>
                            <td class="text-green-500">Selesai</td>
                        </tr>
                        <tr>
                            <td class="py-2">9 Apr 2026</td>
                            <td>Pengiriman</td>
                            <td class="text-yellow-500">Proses</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</x-app-layout>