@extends('layouts.dashboarduser')

@section('title', 'Detail Surat')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-5xl md:px-8">
    <div class="bg-white rounded-2xl shadow p-8 md:p-10">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Detail Surat</h1>
            <div class="flex gap-3">
                @if($pengingat->status !== 'selesai')
                <form action="{{ route('user.progress.post') }}" method="POST">
                    @csrf
                    <input type="hidden" name="pengingat_id" value="{{ $pengingat->id }}">
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                        Selesaikan
                    </button>
                </form>
                @endif
                <a href="{{ route('user.pengingat.index') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    Kembali
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-5 text-sm" role="alert">
            {{ session('success') }}
        </div>
        @endif

        <div class="space-y-6">
            <div>
                <h2 class="text-sm font-semibold text-gray-600">Pengirim</h2>
                <p class="mt-1 text-gray-900">{{ $pengingat->user->full_name }}</p>
            </div>

            <div>
                <h2 class="text-sm font-semibold text-gray-600">Tanggal</h2>
                <p class="mt-1 text-gray-900">{{ \Carbon\Carbon::parse($pengingat->tanggal)->format('d M Y') }}</p>
            </div>

            <div>
                <h2 class="text-sm font-semibold text-gray-600">Kategori</h2>
                <p class="mt-2">
                    <span class="status-badge status-{{ strtolower($pengingat->kategori) }}">
                        {{ ucfirst($pengingat->kategori) }}
                    </span>
                </p>
            </div>

            <div>
                <h2 class="text-sm font-semibold text-gray-600">Disposisi</h2>
                <div class="mt-2 flex flex-wrap gap-2">
                    @php
                    $disposisi = json_decode($pengingat->disposisi);
                    @endphp
                    @if(is_array($disposisi))
                    @foreach($disposisi as $d)
                    <span class="inline-block bg-gray-100 text-gray-700 text-xs font-medium rounded-full px-3 py-1">
                        {{ $d }}
                    </span>
                    @endforeach
                    @else
                    <p class="text-gray-900">{{ $pengingat->disposisi }}</p>
                    @endif
                </div>
            </div>

            <div>
                <h2 class="text-sm font-semibold text-gray-600">Keterangan</h2>
                <p class="mt-1 text-gray-900">{{ $pengingat->text }}</p>
            </div>

            @if($pengingat->file)
            <div class="bg-gray-50 rounded-lg p-4 flex flex-col md:flex-row md:items-center gap-3 mt-2">
                <div class="flex-1">
                    <h2 class="text-sm font-semibold text-gray-600 mb-1">File</h2>
                    <div class="text-xs text-gray-400 mb-1">{{ $pengingat->file }}</div>
                </div>
                @if($pengingat->canAccessFile(auth()->id()))
                <a href="{{ asset('storage/' . $pengingat->file) }}" target="_blank"
                    class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm w-full md:w-auto justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12H9m6 0a6 6 0 11-12 0 6 6 0 0112 0z" />
                    </svg>
                    Buka File
                </a>
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
                <span class="mt-2 text-gray-500 text-sm">Tidak memiliki akses</span>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
.status-badge {
    padding: 4px 10px;
    border-radius: 9999px;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
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
</style>
@endpush
@endsection