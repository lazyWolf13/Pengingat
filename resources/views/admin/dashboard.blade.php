@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Welcome Banner -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-zoom">
        <div class="p-6 bg-gradient-to-r from-blue-500 to-blue-600">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white">
                        Selamat Datang, Admin! 👋
                    </h2>
                    <p class="mt-2 text-blue-100">
                        Sistem Manajemen Pengingat
                    </p>
                </div>
                <div class="h-20 w-20 bg-white rounded-full flex items-center justify-center shadow-lg">
                    <span class="text-4xl font-bold text-blue-600">
                        A
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <!-- Total Users -->
        <div class="bg-white p-6 rounded-xl shadow-md hover-zoom">
            <div class="flex items-center justify-between">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-blue-600 bg-blue-100 px-3 py-1 rounded-full">
                    {{ $totalUsers }} Users
                </span>
            </div>
            <h3 class="text-lg font-bold text-gray-700 mt-4">Total Users</h3>
            <p class="text-gray-500">Pengguna terdaftar</p>
        </div>

        <!-- Tasks -->
        <div class="bg-white p-6 rounded-xl shadow-md hover-zoom">
            <div class="flex items-center justify-between">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-yellow-600 bg-yellow-100 px-3 py-1 rounded-full">
                    {{ $totalTasks }} Tasks
                </span>
            </div>
            <h3 class="text-lg font-bold text-gray-700 mt-4">Total Tasks</h3>
            <p class="text-gray-500">Tugas aktif</p>
        </div>

        <!-- Attendance -->
        <div class="bg-white p-6 rounded-xl shadow-md hover-zoom">
            <div class="flex items-center justify-between">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-green-600 bg-green-100 px-3 py-1 rounded-full">
                    {{ $totalAttendanceRecords }} Records
                </span>
            </div>
            <h3 class="text-lg font-bold text-gray-700 mt-4">Attendance</h3>
            <p class="text-gray-500">Rekam kehadiran</p>
        </div>

        <!-- Leave Requests -->
        <div class="bg-white p-6 rounded-xl shadow-md hover-zoom">
            <div class="flex items-center justify-between">
                <div class="p-3 bg-red-100 rounded-full">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-red-600 bg-red-100 px-3 py-1 rounded-full">
                    {{ $totalLeaveRequests }} Requests
                </span>
            </div>
            <h3 class="text-lg font-bold text-gray-700 mt-4">Leave Requests</h3>
            <p class="text-gray-500">Permohonan cuti</p>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <!-- Admin Users -->
        <div class="bg-white p-6 rounded-xl shadow-md hover-zoom">
            <div class="flex items-center justify-between">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-purple-600 bg-purple-100 px-3 py-1 rounded-full">
                    {{ $totalAdminUsers }} Admins
                </span>
            </div>
            <h3 class="text-lg font-bold text-gray-700 mt-4">Admin Users</h3>
            <p class="text-gray-500">Admin terdaftar</p>
        </div>

        <!-- Reminders -->
        <div class="bg-white p-6 rounded-xl shadow-md hover-zoom">
            <div class="flex items-center justify-between">
                <div class="p-3 bg-indigo-100 rounded-full">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-indigo-600 bg-indigo-100 px-3 py-1 rounded-full">
                    {{ $totalReminders }} Reminders
                </span>
            </div>
            <h3 class="text-lg font-bold text-gray-700 mt-4">Reminders</h3>
            <p class="text-gray-500">Pengingat aktif</p>
        </div>

        <!-- Jobs -->
        <div class="bg-white p-6 rounded-xl shadow-md hover-zoom">
            <div class="flex items-center justify-between">
                <div class="p-3 bg-pink-100 rounded-full">
                    <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-pink-600 bg-pink-100 px-3 py-1 rounded-full">
                    {{ $totalJobs }} Jobs
                </span>
            </div>
            <h3 class="text-lg font-bold text-gray-700 mt-4">Total Jobs</h3>
            <p class="text-gray-500">Pekerjaan aktif</p>
        </div>

        <!-- Photos -->
        <div class="bg-white p-6 rounded-xl shadow-md hover-zoom">
            <div class="flex items-center justify-between">
                <div class="p-3 bg-orange-100 rounded-full">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-orange-600 bg-orange-100 px-3 py-1 rounded-full">
                    {{ $totalFotos }} Photos
                </span>
            </div>
            <h3 class="text-lg font-bold text-gray-700 mt-4">Total Photos</h3>
            <p class="text-gray-500">Foto terunggah</p>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Aktivitas Terkini</h3>
        <div class="space-y-4">
            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                <div class="p-3 bg-blue-100 rounded-full mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Absensi Terbaru</h4>
                    <p class="text-sm text-gray-500">{{ $totalAttendanceRecords }} rekam kehadiran hari ini</p>
                </div>
            </div>

            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                <div class="p-3 bg-green-100 rounded-full mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Surat Masuk</h4>
                    <p class="text-sm text-gray-500">{{ $totalTasks }} tugas aktif dalam sistem</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.hover-zoom {
    transition: all 0.3s ease;
}

.hover-zoom:hover {
    transform: translateY(-5px);
}
</style>
@endpush
@endsection