@extends('layouts.dashboard')

@section('title', 'Attendance Summaries')

@section('content')
<div class="container-fluid px-6 py-8">
    <!-- Grid Container -->
    <div class="max-w-7xl mx-auto">
        <!-- Header Section dengan Background -->
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl shadow-lg p-8 mb-8">
            <div class="flex justify-between items-center">
                <div class="text-white">
                    <h2 class="text-3xl font-bold mb-2">
                        <i class="fas fa-calendar-check mr-3"></i>Attendance Summaries
                    </h2>
                    <p class="text-lg opacity-80">Kelola data ringkasan kehadiran</p>
                </div>
                <div>
                    <a href="{{ route('admin.summariescreate.create') }}" 
                       class="btn btn-light rounded-xl shadow-lg hover:shadow-xl transform transition-all duration-200 hover:-translate-y-1">
                        <i class="fas fa-plus-circle mr-2"></i>Add Attendance Summary
                    </a>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid gap-6">
            <!-- Alert Success dengan Animasi -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-xl" role="alert">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-3xl mr-4 text-emerald-500"></i>
                        </div>
                        <div class="flex-grow">
                            <h4 class="text-lg font-semibold mb-1">Berhasil!</h4>
                            <p class="text-gray-600">{{ session('success') }}</p>
                        </div>
                        <div class="flex-shrink-0">
                            <button type="button" class="text-gray-400 hover:text-gray-500" data-bs-dismiss="alert">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Table Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Month</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Year</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total Present</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($attendanceSummaries as $summary)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $summary->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $summary->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $summary->bulan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $summary->tahun }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $summary->total_hadir }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="{{ route('summaries.edit', $summary->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('summaries.destroy', $summary->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus ringkasan ini?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Container & Layout */
    .max-w-7xl {
        max-width: 80rem;
    }

    /* Button Styles */
    .btn {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .btn-light {
        background-color: rgba(255, 255, 255, 0.9);
        color: #4F46E5;
    }

    .btn-light:hover {
        background-color: white;
    }

    /* Alert Styles */
    .alert {
        background-color: #ECFDF5;
        border-left: 4px solid #34D399;
        padding: 1rem;
    }

    /* Table Styles */
    .table-row-hover:hover {
        background-color: #F9FAFB;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .container-fluid {
            padding: 1rem;
        }
        
        .px-6 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .grid {
            gap: 1rem;
        }
    }

    @media (max-width: 768px) {
        .flex {
            flex-direction: column;
        }

        .btn-light {
            margin-top: 1rem;
        }
    }
</style>

<!-- Tambahkan Font Awesome jika belum ada -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection 