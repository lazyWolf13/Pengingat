<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $adminUsers = AdminUser::all();
        return view('admin.adminuser', compact('adminUsers'));
    }

    public function create()
    {
        return view('admin.adminusercreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin_users',
            'password' => 'required|string|min:8',
        ]);

        AdminUser::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.adminusers.index')
            ->with('success', 'Admin User berhasil ditambahkan!');
    }

    public function edit(AdminUser $adminuser)
    {
        return view('admin.adminuseredit', compact('adminuser'));
    }

    public function update(Request $request, AdminUser $adminuser)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin_users,email,' . $adminuser->id,
        ]);

        $data = [
            'full_name' => $request->full_name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $adminuser->update($data);

        return redirect()->route('admin.adminusers.index')
            ->with('success', 'Data admin user berhasil diperbarui!');
    }

    public function destroy(AdminUser $adminuser)
    {
        $adminuser->delete();
        return redirect()->route('admin.adminusers.index')
            ->with('success', 'Admin User berhasil dihapus!');
    }
} 