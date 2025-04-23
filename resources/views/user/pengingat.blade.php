@extends('layouts.dashboarduser')

@section('title', 'Pengingat')

@section('content')

@push('styles')
<style>
.table-container {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 9999px;
    font-size: 12px;
    font-weight: 500;
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

.hover-zoom {
    transition: all 0.3s ease;
}

.hover-zoom:hover {
    transform: scale(1.02);
}
</style>
@endpush

<div class="container mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Daftar Pengingat</h1>
        <a href="{{ route('user.form_pengingat.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Tambah Pengingat
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Form Pencarian dan Filter -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <form action="{{ route('user.pengingat.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Cari berdasarkan keterangan...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="kategori"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Kategori</option>
                        <option value="biasa" {{ request('kategori') == 'biasa' ? 'selected' : '' }}>Biasa</option>
                        <option value="penting" {{ request('kategori') == 'penting' ? 'selected' : '' }}>Penting
                        </option>
                        <option value="kilat" {{ request('kategori') == 'kilat' ? 'selected' : '' }}>Kilat</option>
                        <option value="rahasia" {{ request('kategori') == 'rahasia' ? 'selected' : '' }}>Rahasia
                        </option>
                        <option value="segera" {{ request('kategori') == 'segera' ? 'selected' : '' }}>Segera</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Cari
                </button>
            </div>
        </form>
    </div>

    @if(isset($formPengingat) && count($formPengingat) > 0)
    <div class="table-container">
        <!-- Informasi Jumlah Data -->
        <div class="bg-gray-50 px-6 py-3 text-sm text-gray-500">
            Menampilkan {{ $formPengingat->firstItem() }} - {{ $formPengingat->lastItem() }} dari
            {{ $formPengingat->total() }} pengingat
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        No
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Pengirim
                    </th>
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
                        Disposisi
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
                @foreach($formPengingat as $index => $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $formPengingat->firstItem() + $index }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @php
                        $sender = \App\Models\User::find($item->sender_id);
                        @endphp
                        {{ $sender ? $sender->full_name : 'Tidak ada pengirim' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="status-badge status-{{ strtolower($item->kategori) }}">
                            {{ ucfirst($item->kategori) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        @php
                        $disposisi = json_decode($item->disposisi);
                        @endphp
                        @if(is_array($disposisi))
                        @foreach($disposisi as $d)
                        <span
                            class="inline-block bg-gray-100 rounded-full px-3 py-1 text-xs font-semibold text-gray-700 mr-2 mb-2">
                            {{ $d }}
                        </span>
                        @endforeach
                        @else
                        {{ $item->disposisi }}
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ Str::limit($item->text, 50) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if($item->file)
                        <a href="{{ asset('storage/files/' . $item->file) }}" target="_blank"
                            class="text-blue-600 hover:text-blue-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Unduh
                        </a>
                        @else
                        -
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $formPengingat->links() }}
    </div>
    @else
    <div class="bg-white rounded-lg shadow-sm p-6 text-center">
        <p class="text-gray-500">Belum ada pengingat yang ditambahkan.</p>
    </div>
    @endif
</div>

@endsection