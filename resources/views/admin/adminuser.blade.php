@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-6 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl shadow-lg p-8 mb-8">
            <div class="flex justify-between items-center">
                <div class="text-white">
                    <h2 class="text-3xl font-bold mb-2">
                        <i class="fas fa-users-cog mr-3"></i>Daftar Admin User
                    </h2>
                    <p class="text-lg opacity-80">Kelola data admin pengguna sistem</p>
                </div>
                <div>
                    <a href="{{ route('admin.adminusers.create') }}" 
                       class="btn btn-light rounded-xl shadow-lg hover:shadow-xl transform transition-all duration-200 hover:-translate-y-1">
                        <i class="fas fa-plus-circle mr-2"></i>Tambah Admin
                    </a>
                </div>
            </div>
        </div>

        <!-- Alert Success dengan Animasi -->
        @if(session('success'))
        <div class="fixed top-4 right-4 z-50 animate-notification" id="notification">
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border-l-4 border-emerald-500 rounded-xl shadow-lg p-6 pr-10 mb-4 flex items-center space-x-4 min-w-[300px] backdrop-blur-sm">
                <div class="flex-shrink-0 bg-emerald-100 rounded-lg p-2">
                    <i class="fas fa-check-circle text-2xl text-emerald-500"></i>
                </div>
                <div class="flex-1">
                    <h4 class="text-emerald-800 font-semibold mb-0.5 text-sm">Berhasil!</h4>
                    <p class="text-emerald-600 text-sm">{{ session('success') }}</p>
                </div>
                <button onclick="closeNotification()" class="absolute right-2 top-2 text-emerald-400 hover:text-emerald-600 transition-colors duration-200 p-1 hover:bg-emerald-100 rounded-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <style>
        @keyframes slideIn {
            0% {
                transform: translateX(100%) translateY(-100%);
                opacity: 0;
            }
            100% {
                transform: translateX(0) translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            0% {
                transform: translateX(0) translateY(0);
                opacity: 1;
            }
            100% {
                transform: translateX(100%) translateY(-100%);
                opacity: 0;
            }
        }

        .animate-notification {
            animation: slideIn 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
        }

        .animate-notification-out {
            animation: slideOut 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
        }

        /* Subtle pulse animation for icon */
        @keyframes gentlePulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .fa-check-circle {
            animation: gentlePulse 2s infinite;
        }
        </style>

        <script>
        // Auto close notification
        function closeNotification() {
            const notification = document.getElementById('notification');
            notification.classList.add('animate-notification-out');
            setTimeout(() => {
                notification.style.display = 'none';
            }, 400);
        }

        // Auto close after 4 seconds
        let closeTimer = setTimeout(closeNotification, 4000);

        // Pause auto-close on hover
        const notification = document.getElementById('notification');
        if (notification) {
            notification.addEventListener('mouseenter', () => {
                clearTimeout(closeTimer);
            });
            
            notification.addEventListener('mouseleave', () => {
                closeTimer = setTimeout(closeNotification, 2000);
            });
        }
        </script>
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
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($adminUsers as $index => $admin)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <div class="h-full w-full rounded-full bg-indigo-500 flex items-center justify-center text-white font-semibold text-lg">
                                            {{ strtoupper(substr($admin->full_name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $admin->full_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                    {{ $admin->email }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.adminusers.edit', $admin->id) }}" 
                                       class="btn btn-info btn-sm rounded-lg transform transition-all duration-200 hover:-translate-y-1">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.adminusers.destroy', $admin->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-danger btn-sm rounded-lg transform transition-all duration-200 hover:-translate-y-1"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus admin ini?')">
                                            <i class="fas fa-trash-alt mr-1"></i> Hapus
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
    /* ... style yang sama seperti sebelumnya ... */
    .btn-light {
        background-color: rgba(255, 255, 255, 0.9);
        color: #4F46E5;
    }
    .btn-info {
        background-color: #3B82F6;
        color: white;
    }
    .btn-danger {
        background-color: #EF4444;
        color: white;
    }
    .btn {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        line-height: 1.25rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        transition: all 0.2s;
    }
</style>
@endsection 