@extends('layouts.dashboard')

@section('title', 'Kelola Admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Kelola Admin</h1>

    <!-- Tombol Tambah Admin -->
    <div class="mb-4">
        <a href="{{ route('admin.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            ➕ Tambah Admin
        </a>
    </div>

    <!-- Tabel Admin -->
    <div class="bg-white p-4 rounded-lg shadow-lg">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-blue-200 text-gray-800">
                    <th class="p-3 text-left">#</th>
                    <th class="p-3 text-left">Nama Lengkap</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admins as $admin)
                <tr class="border-b hover:bg-gray-100">
                    <td class="p-3">{{ $loop->iteration }}</td>
                    <td class="p-3">{{ $admin->full_name }}</td>
                    <td class="p-3">{{ $admin->email }}</td>
                    <td class="p-3">
                        <a href="{{ route('admin.edit', $admin->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">✏️ Edit</a>
                        <form action="{{ route('admin.destroy', $admin->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700" onclick="return confirm('Yakin ingin menghapus admin ini?')">🗑 Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
