@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Gambar Baru</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.image.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Gallery</label>
                <select name="gallery_id" class="w-full border-gray-300 rounded-lg">
                    <option value="">-- Pilih Gallery --</option>
                    @foreach($galleries as $gallery)
                        <option value="{{ $gallery->id }}" {{ old('gallery_id') == $gallery->id ? 'selected' : '' }}>
                            {{ $gallery->post->judul ?? 'Gallery #' . $gallery->id }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Judul Gambar</label>
                <input type="text" name="judul" value="{{ old('judul') }}" class="w-full border-gray-300 rounded-lg">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-2">File Gambar</label>
                <input type="file" name="file" class="w-full border-gray-300 rounded-lg">
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.image.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg mr-2">Batal</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
