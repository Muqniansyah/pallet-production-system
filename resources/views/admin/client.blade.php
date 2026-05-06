<x-app-layout>
    <div class="container mx-auto py-8 px-4">
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 shadow-sm">
            {{ session('success') }}
        </div>
        @endif

        <div class="mb-8">
            <h1 class="text-3xl font-black text-[#1F2937] italic uppercase tracking-tighter">
                Data <span class="text-slate-400 font-light">Client</span>
            </h1>
            <p class="text-slate-500 mt-1">Kelola dan pantau daftar seluruh client yang terdaftar dalam sistem.</p>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="p-4 font-semibold text-gray-700">Nama</th>
                        <th class="p-4 font-semibold text-gray-700">Email</th>
                        <th class="p-4 font-semibold text-gray-700 text-center">Aksi / Role Update</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($clients as $client)
                    <tr class="border-b hover:bg-gray-50 transition-colors">
                        <td class="p-4 text-gray-600">{{ $client->name }}</td>
                        <td class="p-4 text-gray-600">{{ $client->email }}</td>

                        <td class="p-4">
                            <form action="{{ route('admin.client.updateRole', $client->id) }}" method="POST" class="flex items-center justify-center gap-2">
                                @csrf
                                @method('PATCH')

                                <select name="role" class="block w-full px-3 pr-8 py-2 text-sm bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 appearance-none">
                                    <option value="client" {{ $client->role == 'client' ? 'selected' : '' }}>Client</option>
                                    <option value="admin" {{ $client->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>

                                <button type="submit" class="inline-flex items-center px-4 py-1.5 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Update
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- pagination -->
        @if($clients->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $clients->links() }}
        </div>
        @endif
    </div>
</x-app-layout>