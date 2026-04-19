<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ClientController extends Controller
{
    public function index()
    {
        $clients = User::where('role', 'client')->get();
        return view('admin.client', compact('clients'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,client'
        ]);

        $user = User::findOrFail($id);

        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'Role berhasil diubah');
    }
}
