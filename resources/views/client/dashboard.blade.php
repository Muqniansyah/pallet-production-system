<x-app-layout>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Title -->
            <h2 class="text-2xl font-bold mb-6">Dashboard Client</h2>

            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Card 1 -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-gray-500 text-sm">Pesanan Aktif</h3>
                    <p class="text-2xl font-bold">1200</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-gray-500 text-sm">Total Project</h3>
                    <p class="text-2xl font-bold">530</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-gray-500 text-sm">HPP Terunggah</h3>
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
                        @forelse($requests as $req)
                        <tr class="border-b">
                            <td class="py-2">
                                {{ $req->created_at->format('d M Y') }}
                            </td>

                            <td>
                                Request Palet - {{ $req->jenis_palet }}
                            </td>

                            <td>
                                @if($req->status == 'approved')
                                <span class="text-green-500 font-semibold">Disetujui</span>
                                @elseif($req->status == 'rejected')
                                <span class="text-red-500 font-semibold">Ditolak</span>
                                @else
                                <span class="text-yellow-500 font-semibold">Pending</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-gray-400 py-4">
                                Belum ada aktivitas
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>



        </div>
    </div>


</x-app-layout>