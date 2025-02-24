@extends('layouts.dashboard')

@section('title', 'Tambah Admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Admin</h1>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <form action="{{ route('admin.store') }}" method="POST">
            @csrf

            <!-- Nama Lengkap -->
            <div class="mb-4">
                <label for="full_name" class="block text-gray-700 font-semibold">Nama Lengkap:</label>
                <input type="text" name="full_name" id="full_name" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm" required>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold">Email:</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm" required>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold">Password:</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm" required>
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-all duration-300 shadow-lg">
                ✅ Simpan Admin
            </button>
        </form>
    </div>
</div>
@endsection
