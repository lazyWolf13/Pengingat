@extends('layouts.dashboard')

@section('title', 'Profiles')

@section('content')
<div class="container-fluid px-6 py-8">
    <!-- Header Section dengan Background -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-lg p-8 mb-8">
        <div class="flex justify-between items-center">
            <div class="text-white">
                <h2 class="text-3xl font-bold mb-2">
                    <i class="fas fa-calendar-check mr-3"></i>Profiles
                </h2>
                <p class="text-lg opacity-90">Kelola data profil dengan mudah</p>
            </div>
            <div>
                <a href="{{ route('admin.profilescreate.create') }}" 
                   class="bg-white text-blue-600 rounded-xl shadow-lg hover:shadow-xl transform transition-all duration-200 hover:-translate-y-1 px-4 py-2">
                    <i class="fas fa-plus-circle mr-2"></i>Add Profile
                </a>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid gap-6">
        <!-- Alert Success dengan Animasi -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-xl" role="alert">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-3xl mr-4 text-emerald-500"></i>
                    </div>
                    <div class="flex-grow">
                        <h4 class="text-lg font-semibold mb-1">Berhasil!</h4>
                        <p class="text-gray-700">{{ session('success') }}</p>
                    </div>
                    <div class="flex-shrink-0">
                        <button type="button" class="text-gray-400 hover:text-gray-500" data-bs-dismiss="alert">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Table Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-6 py-4 text-left text-gray-600">ID</th>
                            <th class="px-6 py-4 text-left text-gray-600">Judul</th>
                            <th class="px-6 py-4 text-left text-gray-600">Isi</th>
                            <th class="px-6 py-4 text-center text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($profiles as $profile)
                        <tr class="border-b hover:bg-gray-50 transition-colors duration-200">
                            <td class="py-2 px-4 text-gray-700">{{ $profile->id }}</td>
                            <td class="py-2 px-4 text-gray-700">{{ $profile->judul }}</td>
                            <td class="py-2 px-4 text-gray-700">{{ $profile->isi }}</td>
                            <td class="py-2 px-4 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.profilesedit.edit', $profile->id) }}" 
                                    class="bg-blue-600 text-white rounded-lg px-4 py-2 hover:bg-blue-700 transition duration-200 flex items-center">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.profiles.destroy', $profile->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-600 text-white rounded-lg px-4 py-2 hover:bg-red-700 transition duration-200 flex items-center">
                                            <i class="fas fa-trash-alt mr-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .alert {
        background-color: #ECFDF5;
        border-left: 4px solid #34D399;
        padding: 1rem;
    }

    .table {
        border-collapse: collapse;
        width: 100%;
    }

    .table th, .table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }

    .table th {
        background-color: #f9fafb;
        font-weight: bold;
    }

    .table tr:hover {
        background-color: #f1f5f9;
    }

    .btn {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: #4F46E5;
        color: white;
    }

    .btn-primary:hover {
        background-color: #4338CA;
    }

    .btn-secondary {
        background-color: #94a3b8;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #64748b;
    }
</style>

<!-- Tambahkan Font Awesome jika belum ada -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection 