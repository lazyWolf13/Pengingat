@extends('layouts.dashboard')

@section('title', 'Rekap Pengingat')

@php
use App\Models\FormPengingat;
use App\Models\User;
$rekap = FormPengingat::with('user')->get();
@endphp

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-semibold mb-6 text-gray-800">Rekap Pengingat</h2>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="w-full bg-blue-600 text-white uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Pengirim</th>
                        <th class="py-3 px-6 text-left">Penerima</th>
                        <th class="py-3 px-6 text-left">Kategori</th>
                        <th class="py-3 px-6 text-left">Tanggal</th>
                        <th class="py-3 px-6 text-left">Disposisi</th>
                        <th class="py-3 px-6 text-left">Text</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach ($rekap as $i => $item)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left">{{ $item->user->full_name ?? '-' }}</td>
                        <td class="py-3 px-6 text-left">
                            @php
                            $userIds = $item->user_ids;
                            if (is_string($userIds)) {
                            $userIds = json_decode($userIds, true);
                            }
                            $userIds = is_array($userIds) ? $userIds : [];
                            $menerimaUsers = User::whereIn('id', $userIds)->pluck('full_name')->toArray();
                            @endphp
                            @if(count($menerimaUsers) > 0)
                            @foreach($menerimaUsers as $menerima)
                            <span
                                class="inline-block bg-green-500 text-white rounded-full px-2 py-1 text-xs font-semibold mr-1">
                                {{ $menerima }}
                            </span>
                            @endforeach
                            @else
                            -
                            @endif
                        </td>
                        <td class="py-3 px-6 text-left">
                            <span
                                class="inline-block bg-blue-500 text-white rounded-full px-3 py-1 text-xs font-semibold">
                                {{ ucfirst($item->kategori) }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-left">{{ $item->tanggal->format('d-m-Y') }}</td>
                        <td class="py-3 px-6 text-left">
                            @php
                            $disposisi = is_string($item->disposisi) ? json_decode($item->disposisi, true) :
                            $item->disposisi;
                            @endphp
                            @foreach ($disposisi as $dis)
                            <span
                                class="inline-block bg-teal-400 text-white rounded-full px-2 py-1 text-xs font-semibold mr-1">
                                {{ $dis }}
                            </span>
                            @endforeach
                        </td>
                        <td class="py-3 px-6 text-left">{{ $item->text ?? '-' }}</td>
                        <td class="py-3 px-6 text-center">
                            <a href="{{ route('admin.rekap_pengingat.show', $item->id) }}" title="Lihat Detail"
                                class="text-blue-600 hover:text-blue-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24"
    stroke="currentColor" stroke-width="2">
    @endsection