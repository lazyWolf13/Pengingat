@extends('layouts.dashboard')

@section('title', 'Detail Absensi')

@section('content')
<div class="container-fluid px-4 py-6">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-gray-800">Detail Absensi</h1>
            <div class="flex space-x-3">
                <a href="{{ route('admin.attendance.edit', $record) }}" class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span>Edit</span>
                </a>
                <a href="{{ route('admin.attendance.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="{{ route('admin.attendance.index') }}" class="text-gray-500 hover:text-gray-600">Data Absensi</a>
                    <svg class="w-5 h-5 text-gray-400 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </li>
                <li class="text-gray-600">Detail Absensi</li>
            </ol>
        </nav>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <!-- Employee Info -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Karyawan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Nama Karyawan</p>
                        <p class="text-base font-medium text-gray-900">{{ $record->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">ID Karyawan</p>
                        <p class="text-base font-medium text-gray-900">{{ $record->user->employee_id ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Attendance Info -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Absensi</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Tanggal</p>
                        <p class="text-base font-medium text-gray-900">{{ \Carbon\Carbon::parse($record->tanggal)->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Status</p>
                        <div>
                            @if($record->status == 'hadir')
                                <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-800">Hadir</span>
                            @elseif($record->status == 'izin')
                                <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">Izin</span>
                            @elseif($record->status == 'cuti')
                                <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">Cuti</span>
                            @elseif($record->status == 'alpa')
                                <span class="px-3 py-1 text-sm rounded-full bg-red-100 text-red-800">Alpa</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Waktu Check-in</p>
                        <p class="text-base font-medium text-gray-900">
                            {{ $record->waktu_check_in ? \Carbon\Carbon::parse($record->waktu_check_in)->format('H:i') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Waktu Check-out</p>
                        <p class="text-base font-medium text-gray-900">
                            {{ $record->waktu_check_out ? \Carbon\Carbon::parse($record->waktu_check_out)->format('H:i') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Ketepatan Waktu</p>
                        <div>
                            @if($record->ketepatan_waktu == 'tepat waktu')
                                <span class="px-3 py-1 text-sm rounded-full bg-green-100 text-green-800">Tepat Waktu</span>
                            @elseif($record->ketepatan_waktu == 'terlambat')
                                <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">Terlambat</span>
                            @elseif($record->ketepatan_waktu == 'lembur')
                                <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">Lembur</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Durasi Lembur</p>
                        <p class="text-base font-medium text-gray-900">{{ $record->durasi_lembur ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Location Info -->
            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Lokasi</h2>
                <div>
                    <p class="text-sm text-gray-600 mb-1">Lokasi Absen</p>
                    <p class="text-base font-medium text-gray-900">{{ $record->lokasi_absen ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Button -->
    <div class="mt-6">
        <form action="{{ route('admin.attendance.destroy', $record) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data absensi ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                <span>Hapus Data Absensi</span>
            </button>
        </form>
    </div>
</div>
@endsection 