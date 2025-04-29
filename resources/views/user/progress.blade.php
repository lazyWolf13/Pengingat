@extends('layouts.dashboarduser')

@section('title', 'Progress Kegiatan')

@section('content')
<div class="container mx-auto px-3 py-4 max-w-full">
    <div class="bg-white rounded-lg shadow-sm p-4">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Progress Kegiatan</h1>
                <p class="text-sm text-gray-500 mt-1">Daftar kegiatan yang telah diselesaikan</p>
            </div>
            <a href="{{ route('user.pengingat.index') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
        @endif

        @if(isset($pengingat))
        <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-xl p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Detail Kegiatan</h2>
                <span class="status-badge status-{{ strtolower($pengingat->kategori) }}">
                    {{ ucfirst($pengingat->kategori) }}
                </span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Pengirim</h3>
                    <p class="text-gray-800">{{ $pengingat->user->full_name }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Tanggal</h3>
                    <p class="text-gray-800">{{ \Carbon\Carbon::parse($pengingat->tanggal)->format('d M Y') }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Disposisi</h3>
                    <div class="flex flex-wrap gap-2">
                        @php
                        $disposisi = json_decode($pengingat->disposisi);
                        @endphp
                        @if(is_array($disposisi))
                        @foreach($disposisi as $d)
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            {{ $d }}
                        </span>
                        @endforeach
                        @else
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            {{ $pengingat->disposisi }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Keterangan</h3>
                    <p class="text-gray-800">{{ $pengingat->text }}</p>
                </div>
                @if($pengingat->file)
                <div class="bg-white p-4 rounded-lg shadow-sm flex flex-col md:flex-row md:items-center gap-3">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-500 mb-2">File</h3>
                        <div class="text-xs text-gray-400 mb-1">{{ $pengingat->file }}</div>
                    </div>
                    @if($pengingat->canAccessFile(auth()->id()))
                    <a href="{{ route('user.pengingat.download', $pengingat->id) }}" target="_blank"
                        class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm w-full md:w-auto justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Unduh File
                    </a>
                    @else
                    <span class="text-gray-500">Tidak memiliki akses</span>
                    @endif
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Daftar Pengingat yang Sudah Selesai -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Daftar Kegiatan Selesai</h2>
                    <p class="text-sm text-gray-500 mt-1">Total: {{ $selesaiPengingat->total() }} kegiatan</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Keterangan
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                File
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($selesaiPengingat as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="status-badge status-{{ strtolower($item->kategori) }}">
                                    {{ ucfirst($item->kategori) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ Str::limit($item->text, 50) }}</div>
                                <div class="text-xs text-gray-500 mt-1">Oleh: {{ $item->user->full_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->file)
                                @if($item->canAccessFile(auth()->id()))
                                <a href="{{ route('user.pengingat.download', $item->id) }}" target="_blank"
                                    class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="text-xs">{{ Str::limit($item->file, 20) }}</span>
                                </a>
                                @else
                                <span class="text-gray-500 text-xs">Tidak memiliki akses</span>
                                @endif
                                @else
                                <span class="text-gray-500 text-xs">Tidak ada file</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <a href="{{ route('user.progress', ['pengingat_id' => $item->id]) }}"
                                    class="text-blue-600 hover:text-blue-900 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-lg font-medium">Belum ada kegiatan yang diselesaikan</p>
                                    <p class="text-sm mt-1">Semua kegiatan yang telah diselesaikan akan muncul di sini
                                    </p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $selesaiPengingat->links() }}
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.status-badge {
    padding: 4px 8px;
    border-radius: 9999px;
    font-size: 12px;
    font-weight: 500;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.status-biasa {
    background: #E5E7EB;
    color: #374151;
}

.status-penting {
    background: #FEE2E2;
    color: #DC2626;
}

.status-kilat {
    background: #FEF3C7;
    color: #D97706;
}

.status-rahasia {
    background: #DBEAFE;
    color: #2563EB;
}

.status-segera {
    background: #D1FAE5;
    color: #059669;
}

.status-selesai {
    background: #E5E7EB;
    color: #374151;
}

/* Pagination Styles */
.pagination {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
}

.pagination>* {
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    background-color: white;
    border: 1px solid #E5E7EB;
    color: #4B5563;
    font-size: 0.875rem;
    transition: all 0.2s;
}

.pagination>*:hover {
    background-color: #F3F4F6;
}

.pagination .active {
    background-color: #3B82F6;
    color: white;
    border-color: #3B82F6;
}

.pagination .disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>
@endpush
@endsection