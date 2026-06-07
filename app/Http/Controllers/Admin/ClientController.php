<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// pemanggilan model
use App\Models\User;

class ClientController extends Controller
{
    // Menampilkan semua data client dengan pagination
    public function index()
    {
        $clients = User::where('role', 'client')->paginate(5);

        return view('admin.client', compact('clients'));
    }

    // Mengubah role pengguna berdasarkan ID
    public function updateRole(Request $request, $id)
    {
        // Validasi role yang diizinkan untuk diubah oleh admin
        $request->validate([
            'role' => 'required|in:admin,client'
        ]);

        $user = User::findOrFail($id);

        // Update role pengguna
        $user->role = $request->role;
        // Simpan perubahan ke database
        $user->save();

        return redirect()->back()->with('success', 'Role berhasil diubah');
    }
}
