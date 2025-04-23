@extends('layouts.dashboard')

@section('title', 'Detail Pengingat')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-semibold mb-6 text-gray-800">Detail Pengingat</h2>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="mb-4">
            <strong>Pengirim:</strong> {{ $item->user->full_name ?? '-' }}
        </div>
        <div class="mb-4">
            <strong>Penerima:</strong>
            @php
            use App\Models\User;
            $userIds = $item->user_ids;
            if (is_string($userIds)) {
            $userIds = json_decode($userIds, true);
            }
            $userIds = is_array($userIds) ? $userIds : [];
            $menerimaUsers = User::whereIn('id', $userIds)->pluck('full_name')->toArray();
            @endphp
            @if(count($menerimaUsers) > 0)
            @foreach($menerimaUsers as $menerima)
            <span class="inline-block bg-green-500 text-white rounded-full px-2 py-1 text-xs font-semibold mr-1">
                {{ $menerima }}
            </span>
            @endforeach
            @else
            -
            @endif
        </div>
        <div class="mb-4">
            <strong>Kategori:</strong> {{ ucfirst($item->kategori) }}
        </div>
        <div class="mb-4">
            <strong>Tanggal:</strong> {{ $item->tanggal->format('d-m-Y') }}
        </div>
        <div class="mb-4">
            <strong>Disposisi:</strong>
            @php
            $disposisi = is_string($item->disposisi) ? json_decode($item->disposisi, true) : $item->disposisi;
            @endphp
            @foreach ($disposisi as $dis)
            <span class="inline-block bg-teal-400 text-white rounded-full px-2 py-1 text-xs font-semibold mr-1">
                {{ $dis }}
            </span>
            @endforeach
        </div>
        <div class="mb-4">
            <strong>Text:</strong>
            <p>{{ $item->text ?? '-' }}</p>
        </div>
        @if($item->file)
        <div class="mb-4">
            <strong>File:</strong>
            @php
            $fileUrl = asset('storage/' . $item->file);
            $fileExtension = pathinfo($item->file, PATHINFO_EXTENSION);
            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];
            @endphp
            @if(in_array(strtolower($fileExtension), $imageExtensions))
            <img src="{{ $fileUrl }}" alt="File Foto" class="max-w-full h-auto rounded shadow" />
            @else
            <a href="{{ $fileUrl }}" target="_blank" class="text-blue-600 hover:underline">Download File</a>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection