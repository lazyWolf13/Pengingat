@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Post</h1>
        <a href="{{ route('admin.posts.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Tambah Post
        </a>
    </div>

    @if(session('success'))
        <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
            <button type="button" class="absolute top-0 right-0 px-4 py-3" onclick="document.getElementById('success-message').style.display='none'">
                <span class="text-2xl">&times;</span>
            </button>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow">
        <table class="w-full table-fixed text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="w-12 px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                    <th class="w-1/4 px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                    <th class="w-1/6 px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="w-1/6 px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="w-1/6 px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Penulis</th>
                    <th class="w-1/6 px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                    <th class="w-1/6 px-2 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($posts as $post)
                    <tr>
                        <td class="px-2 py-2 whitespace-nowrap text-center text-gray-900">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-2 py-2 whitespace-nowrap text-center text-gray-900">
                            <div class="truncate" title="{{ $post->judul }}">
                                {{ $post->judul }}
                            </div>
                        </td>
                        <td class="px-2 py-2 whitespace-nowrap text-center text-gray-500">
                            {{ $post->kategori->judul }}
                        </td>
                        <td class="px-2 py-2 whitespace-nowrap text-center">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $post->status === 'published' ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-2 py-2 whitespace-nowrap text-center text-gray-500">
                            {{ $post->adminUser->full_name }}
                        </td>
                        <td class="px-2 py-2 whitespace-nowrap text-center text-gray-500">
                            {{ $post->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-2 py-2 whitespace-nowrap text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('admin.posts.edit', $post) }}" 
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded-lg flex items-center text-sm">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-lg flex items-center text-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus post ini?')">
                                        <i class="fas fa-trash mr-1"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-2 py-2 text-center text-gray-500">
                            Tidak ada post yang ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.opacity = '0';
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 500);
            }, 3000);
        }
    });
</script>
@endpush
@endsection 