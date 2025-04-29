@extends('layouts.dashboarduser')

@section('title', 'Pengingat')

@section('content')

@push('styles')
<style>
.table-container {
    background: white;
    border-radius: 6px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin: 0.5rem 0;
    width: 100%;
}

.status-badge {
    padding: 2px 6px;
    border-radius: 9999px;
    font-size: 11px;
    font-weight: 500;
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

/* Responsive table styles */
@media (max-width: 768px) {
    .table-container {
        margin: 0.25rem 0;
    }

    .responsive-header {
        flex-direction: column;
        gap: 0.5rem;
    }

    .search-form {
        width: 100%;
    }

    .search-form .grid {
        grid-template-columns: 1fr;
    }

    /* Adjust table for smaller screens */
    table {
        width: 100%;
        display: block;
    }

    thead {
        display: none;
    }

    tbody {
        display: block;
        width: 100%;
    }

    tr {
        display: block;
        margin-bottom: 0.5rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        padding: 0.5rem;
    }

    td {
        display: block;
        text-align: right;
        padding: 0.25rem 0;
        border: none;
        position: relative;
    }

    td::before {
        content: attr(data-label);
        position: absolute;
        left: 0;
        width: 50%;
        padding-right: 0.5rem;
        font-weight: 600;
        text-align: left;
        font-size: 0.75rem;
    }
}

/* Card styles for mobile view */
@media (max-width: 640px) {
    .table-container {
        display: none;
    }

    .card-container {
        display: block;
    }

    .pengingat-card {
        background: white;
        border-radius: 6px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 0.5rem;
        padding: 0.75rem;
        width: 100%;
    }

    .pengingat-card .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.25rem;
    }

    .pengingat-card .card-content {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.25rem;
    }

    .pengingat-card .card-item {
        display: flex;
        flex-direction: column;
        gap: 0.125rem;
    }

    .pengingat-card .card-label {
        font-size: 0.7rem;
        color: #6B7280;
    }

    .pengingat-card .card-value {
        font-size: 0.8rem;
        color: #111827;
        word-break: break-word;
    }

    .pengingat-card .penerima-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.25rem;
    }

    .pengingat-card .penerima-tag {
        background: #E5E7EB;
        padding: 0.125rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.7rem;
        color: #374151;
    }

    .pengingat-card .disposisi-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.25rem;
    }

    .pengingat-card .disposisi-tag {
        background: #E5E7EB;
        padding: 0.125rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.7rem;
        color: #374151;
    }

    .pengingat-card .card-actions {
        display: flex;
        justify-content: flex-end;
        gap: 0.25rem;
        margin-top: 0.5rem;
    }
}

/* Desktop view */
@media (min-width: 641px) {
    .card-container {
        display: none;
    }

    /* Ensure table fits within container */
    table {
        width: 100%;
        table-layout: fixed;
    }

    th,
    td {
        padding: 0.5rem;
        word-break: break-word;
        font-size: 0.875rem;
    }

    /* Adjust column widths */
    th:nth-child(1),
    td:nth-child(1) {
        width: 5%;
    }

    /* No */
    th:nth-child(2),
    td:nth-child(2) {
        width: 15%;
    }

    /* Pengirim */
    th:nth-child(3),
    td:nth-child(3) {
        width: 10%;
    }

    /* Penerima */
    th:nth-child(4),
    td:nth-child(4) {
        width: 10%;
    }

    /* Tanggal */
    th:nth-child(5),
    td:nth-child(5) {
        width: 10%;
    }

    /* Kategori */
    th:nth-child(6),
    td:nth-child(6) {
        width: 20%;
    }

    /* Disposisi */
    th:nth-child(7),
    td:nth-child(7) {
        width: 25%;
    }

    /* Keterangan */
    th:nth-child(8),
    td:nth-child(8) {
        width: 10%;
    }

    /* File */
    th:nth-child(9),
    td:nth-child(9) {
        width: 5%;
    }

    /* Aksi */
}
</style>
@endpush

<div class="container mx-auto px-3 py-4 max-w-full">
    <div class="responsive-header flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold">Daftar Pengingat</h1>
        <a href="{{ route('user.form_pengingat.create') }}"
            class="bg-blue-600 text-white px-3 py-1.5 rounded hover:bg-blue-700 transition whitespace-nowrap text-sm">
            Tambah Pengingat
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-3 py-2 rounded relative mb-3 text-sm"
        role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Form Pencarian dan Filter -->
    <div class="bg-white rounded-lg shadow-sm p-3 mb-4 search-form">
        <form action="{{ route('user.pengingat.index') }}" method="GET" class="space-y-3">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Pencarian</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full px-3 py-1.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                        placeholder="Cari berdasarkan keterangan...">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="kategori"
                        class="w-full px-3 py-1.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
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
                    <label class="block text-xs font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                        class="w-full px-3 py-1.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-600 text-white px-3 py-1.5 rounded hover:bg-blue-700 transition text-sm">
                    Cari
                </button>
            </div>
        </form>
    </div>

    @if(isset($formPengingat) && count($formPengingat) > 0)
    <!-- Desktop Table View -->
    <div class="table-container">
        <!-- Informasi Jumlah Data -->
        <div class="bg-gray-50 px-4 py-2 text-xs text-gray-500">
            Menampilkan {{ $formPengingat->firstItem() }} - {{ $formPengingat->lastItem() }} dari
            {{ $formPengingat->total() }} pengingat
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        No
                    </th>
                    <th scope="col"
                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Pengirim
                    </th>
                    <th scope="col"
                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Penerima
                    </th>
                    <th scope="col"
                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tanggal
                    </th>
                    <th scope="col"
                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Kategori
                    </th>
                    <th scope="col"
                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Disposisi
                    </th>
                    <th scope="col"
                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Keterangan
                    </th>
                    <th scope="col"
                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        File
                    </th>
                    <th scope="col"
                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($formPengingat as $index => $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500" data-label="No">
                        {{ $formPengingat->firstItem() + $index }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900" data-label="Pengirim">
                        {{ $item->user?->full_name ?? '-' }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900" data-label="Penerima">
                        @php
                        $userIds = json_decode($item->user_ids) ?? [];
                        $userPenerima = \App\Models\User::whereIn('id', $userIds)->get();
                        @endphp
                        @if(is_array($userIds) && count($userIds) > 0)
                        @foreach($userPenerima as $p)
                        <span
                            class="inline-block bg-gray-100 rounded-full px-2 py-0.5 text-xs font-semibold text-gray-700 mr-1 mb-1">
                            {{ $p->full_name }}
                        </span>
                        @endforeach
                        @else
                        -
                        @endif
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900" data-label="Tanggal">
                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap" data-label="Kategori">
                        <span class="status-badge status-{{ strtolower($item->kategori) }}">
                            {{ ucfirst($item->kategori) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-900" data-label="Disposisi">
                        @php
                        $disposisi = json_decode($item->disposisi);
                        @endphp
                        @if(is_array($disposisi) && count($disposisi) > 0)
                        @foreach($disposisi as $d)
                        <span
                            class="inline-block bg-gray-100 rounded-full px-2 py-0.5 text-xs font-semibold text-gray-700 mr-1 mb-1">
                            {{ $d }}
                        </span>
                        @endforeach
                        @else
                        {{ $item->disposisi }}
                        @endif
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-900" data-label="Keterangan">
                        {{ Str::limit($item->text, 50) }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900" data-label="File">
                        @if($item->file)
                        <a href="{{ asset('storage/files/' . $item->file) }}" target="_blank"
                            class="text-blue-600 hover:text-blue-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline" fill="none"
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
                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium" data-label="Aksi">
                        <a href="{{ route('user.pengingat.show', $item->id) }}"
                            class="text-blue-600 hover:text-blue-900 mr-3">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $formPengingat->links() }}
    </div>
    @else
    <div class="bg-white rounded-lg shadow-sm p-4 text-center">
        <p class="text-gray-500 text-sm">Belum ada pengingat yang ditambahkan.</p>
    </div>
    @endif
</div>

@endsection