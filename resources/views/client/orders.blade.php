<x-app-layout>

    <h1 class="text-2xl font-bold mb-6">Order Saya</h1>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full text-sm">

            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3">Project</th>
                    <th class="p-3">Qty</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">HPP</th>
                </tr>
            </thead>

            <tbody>
                @forelse($orders as $order)
                <tr class="border-b">

                    <td class="p-3">{{ $order->nama_project }}</td>
                    <td class="p-3">{{ $order->qty }}</td>

                    <td class="p-3">
                        <span class="
                            px-2 py-1 rounded text-white text-xs
                            {{ $order->status == 'deal' ? 'bg-green-500' : 'bg-yellow-500' }}
                        ">
                            {{ $order->status }}
                        </span>
                    </td>

                    <td class="p-3">
                        @if($order->hpp)
                        <a href="{{ asset('storage/' . $order->hpp->file_hpp) }}"
                            target="_blank"
                            class="text-blue-500 underline">
                            Download
                        </a>
                        @else
                        <span class="text-gray-400 text-xs">Belum ada</span>
                        @endif
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-400">
                        Belum ada order
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</x-app-layout>