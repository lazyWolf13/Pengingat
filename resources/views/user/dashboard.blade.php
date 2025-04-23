@extends('layouts.dashboarduser')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-zoom">
        <div class="p-6 bg-gradient-to-r from-green-500 to-green-600">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white">
                        Selamat Datang, {{ auth()->user()->full_name }}! 👋
                    </h2>
                    <p class="mt-2 text-green-100">
                        {{ auth()->user()->subdit }} - {{ auth()->user()->lembaga }}
                    </p>
                </div>
                <div class="h-20 w-20 bg-white rounded-full flex items-center justify-center shadow-lg">
                    <span class="text-4xl font-bold text-green-600">
                        {{ strtoupper(substr(auth()->user()->full_name, 0, 1)) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Absensi Hari Ini -->
        <div class="bg-white p-6 rounded-xl shadow-md hover-zoom">
            <div class="flex items-center justify-between">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-green-600 bg-green-100 px-3 py-1 rounded-full">
                    Hari Ini
                </span>
            </div>
            <h3 class="text-lg font-bold text-gray-700 mt-4">Absensi</h3>
            <p class="text-gray-500">08:00 WIB</p>
        </div>

        <!-- Tugas Aktif -->
        <div class="bg-white p-6 rounded-xl shadow-md hover-zoom">
            <div class="flex items-center justify-between">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-yellow-600 bg-yellow-100 px-3 py-1 rounded-full">
                    5 Tugas
                </span>
            </div>
            <h3 class="text-lg font-bold text-gray-700 mt-4">Tugas Aktif</h3>
            <p class="text-gray-500">Perlu diselesaikan</p>
        </div>

        <!-- Dokumen -->
        <div class="bg-white p-6 rounded-xl shadow-md hover-zoom">
            <div class="flex items-center justify-between">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-purple-600 bg-purple-100 px-3 py-1 rounded-full">
                    12 Files
                </span>
            </div>
            <h3 class="text-lg font-bold text-gray-700 mt-4">Dokumen</h3>
            <p class="text-gray-500">Dokumen aktif</p>
        </div>

        <!-- Notifikasi -->
        <div class="bg-white p-6 rounded-xl shadow-md hover-zoom">
            <div class="flex items-center justify-between">
                <div class="p-3 bg-red-100 rounded-full">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <span class="text-sm font-semibold text-red-600 bg-red-100 px-3 py-1 rounded-full">
                    3 Baru
                </span>
            </div>
            <h3 class="text-lg font-bold text-gray-700 mt-4">Notifikasi</h3>
            <p class="text-gray-500">Belum dibaca</p>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Aktivitas Terkini</h3>
        <div class="space-y-4">
            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                <div class="p-3 bg-green-100 rounded-full mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Tugas baru ditambahkan</h4>
                    <p class="text-sm text-gray-500">Laporan Bulanan - Deadline 30 April 2024</p>
                </div>
            </div>

            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                <div class="p-3 bg-blue-100 rounded-full mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Absen Masuk</h4>
                    <p class="text-sm text-gray-500">Hari ini - 08:00 WIB</p>
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