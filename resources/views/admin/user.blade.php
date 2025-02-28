@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-6 py-8">
    <!-- Grid Container -->
    <div class="max-w-7xl mx-auto">
        <!-- Header Section dengan Background -->
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl shadow-lg p-8 mb-8">
            <div class="flex justify-between items-center">
                <div class="text-white">
                    <h2 class="text-3xl font-bold mb-2">
                        <i class="fas fa-users mr-3"></i>Daftar User
                    </h2>
                    <p class="text-lg opacity-80">Kelola data pengguna sistem</p>
                </div>
                <div>
                    <a href="{{ route('admin.users.create') }}" 
                       class="btn btn-light rounded-xl shadow-lg hover:shadow-xl transform transition-all duration-200 hover:-translate-y-1">
                        <i class="fas fa-plus-circle mr-2"></i>Tambah User
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
                            <p class="text-gray-600">{{ session('success') }}</p>
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
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Lengkap</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Subdit</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Lembaga</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($users as $index => $user)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <div class="h-full w-full rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold text-lg">
                                                {{ strtoupper(substr($user->full_name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->full_name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                        {{ $user->email }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $user->subdit }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                        {{ $user->lembaga }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-danger btn-sm rounded-lg transform transition-all duration-200 hover:-translate-y-1"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                            <i class="fas fa-trash-alt mr-1"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Container & Layout */
    .max-w-7xl {
        max-width: 80rem;
    }

    /* Button Styles */
    .btn {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .btn-light {
        background-color: rgba(255, 255, 255, 0.9);
        color: #4F46E5;
    }

    .btn-light:hover {
        background-color: white;
    }

    .btn-danger {
        background-color: #EF4444;
        color: white;
        padding: 0.5rem 1rem;
    }

    .btn-danger:hover {
        background-color: #DC2626;
    }

    /* Alert Styles */
    .alert {
        background-color: #ECFDF5;
        border-left: 4px solid #34D399;
        padding: 1rem;
    }

    .alert.fade.show {
        animation: slideInDown 0.5s ease-out;
    }

    @keyframes slideInDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Table Styles */
    .table-row-hover:hover {
        background-color: #F9FAFB;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .container-fluid {
            padding: 1rem;
        }
        
        .px-6 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .grid {
            gap: 1rem;
        }
    }

    @media (max-width: 768px) {
        .flex {
            flex-direction: column;
        }

        .btn-light {
            margin-top: 1rem;
        }
    }
</style>

<!-- Tambahkan Font Awesome jika belum ada -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection 