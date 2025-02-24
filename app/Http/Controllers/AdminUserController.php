<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    // Menampilkan daftar admin
    public function index()
    {
        $admins = AdminUser::all();
        return view('admin.kelola', compact('admins'));
    }

    // Menampilkan form tambah admin
    public function create()
    {
        return view('admin.kelolacreate');
    }

    // Menyimpan data admin baru
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_users,email',
            'password' => 'required|min:6',
        ]);

        AdminUser::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
        ]);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    // Menampilkan form edit admin
    public function edit($id)
    {
        $admin = AdminUser::findOrFail($id);
        return view('admin.edit', compact('admin'));
    }

    // Memperbarui data admin
    public function update(Request $request, $id)
    {
        $admin = AdminUser::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:admin_users,email,' . $id,
            'password' => 'nullable|min:6',
        ]);

        $admin->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $admin->password,
        ]);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil diperbarui.');
    }

    // Menghapus admin
    public function destroy($id)
    {
        AdminUser::findOrFail($id)->delete();
        return redirect()->route('admin.index')->with('success', 'Admin berhasil dihapus.');
    }
}
