@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Gambar</h1>
        <a href="{{ route('admin.image.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Gambar
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4">
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-xs border-collapse">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-center font-medium text-gray-500 uppercase tracking-wider border border-gray-300">No</th>
                            <th class="px-4 py-2 text-center font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Gallery</th>
                            <th class="px-4 py-2 text-center font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Judul</th>
                            <th class="px-4 py-2 text-center font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Gambar</th>
                            <th class="px-4 py-2 text-center font-medium text-gray-500 uppercase tracking-wider border border-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($images as $index => $image)
                        <tr class="text-center">
                            <td class="px-4 py-2 text-gray-900 border border-gray-300">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-4 py-2 text-gray-500 text-xs border border-gray-300">
                                <div class="break-words w-full text-ellipsis overflow-hidden" style="max-width: 200px;">
                                    {{ $image->gallery->post->judul ?? '-' }}
                                </div>
                            </td>
                            <td class="px-4 py-2 text-gray-900 text-xs border border-gray-300">
                                <div class="break-words w-full text-ellipsis overflow-hidden" style="max-width: 200px;">
                                    {{ $image->judul }}
                                </div>
                            </td>
                            <td class="px-4 py-2 border border-gray-300 w-32"> <!-- Lebar kolom gambar lebih besar -->
                                <img src="{{ asset('storage/' . $image->file) }}" alt="{{ $image->judul }}" class="h-24 mx-auto object-contain"> <!-- Gambar lebih besar dengan ukuran h-24 -->
                            </td>
                            <td class="px-4 py-2 border border-gray-300">
                                <div class="flex flex-col items-center space-y-1">
                                    <a href="{{ route('admin.image.edit', $image->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded-lg flex items-center text-xs">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.image.destroy', $image->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-lg flex items-center text-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus gambar ini?')">
                                            Hapus
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

@endsection
