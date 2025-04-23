@extends('layouts.dashboard')

@section('title', 'Generate Ringkasan Absensi')

@section('content')
<div class="container-fluid px-4 py-6">
    <div class="max-w-3xl mx-auto">
        <!-- Header Section -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Generate Ringkasan Absensi</h1>
                <p class="text-sm text-gray-500 mt-1">Buat ringkasan absensi untuk periode tertentu</p>
            </div>
            <a href="{{ route('admin.summaries.index') }}" class="text-gray-600 hover:text-gray-800 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        </div>

        <!-- Form Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form id="generateForm" action="{{ route('admin.summaries.generate') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Month Selection -->
                    <div>
                        <label for="bulan" class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                        <select name="bulan" id="bulan" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200" required>
                            @foreach(range(1, 12) as $month)
                                <option value="{{ $month }}" {{ date('n') == $month ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Year Selection -->
                    <div>
                        <label for="tahun" class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                        <select name="tahun" id="tahun" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition duration-200" required>
                            @foreach(range(date('Y')-5, date('Y')) as $year)
                                <option value="{{ $year }}" {{ date('Y') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6">
                    <a href="{{ route('admin.summaries.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition duration-200">
                        Kembali
                    </a>
                    <button type="submit" id="generateButton" class="px-6 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition duration-200 flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                        </svg>
                        <span>Generate Ringkasan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('generateForm');
    const generateButton = document.getElementById('generateButton');
    const buttonText = generateButton.querySelector('span');
    const buttonIcon = generateButton.querySelector('svg');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Disable button and show loading state
        generateButton.disabled = true;
        buttonText.textContent = 'Generating...';
        buttonIcon.classList.add('animate-spin');

        // Submit form via AJAX
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = '{{ route("admin.summaries.index") }}';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan sistem'
            });
        })
        .finally(() => {
            // Reset button state
            generateButton.disabled = false;
            buttonText.textContent = 'Generate Ringkasan';
            buttonIcon.classList.remove('animate-spin');
        });
    });
});
</script>
@endpush 