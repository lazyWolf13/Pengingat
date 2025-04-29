@extends('layouts.dashboarduser')

@section('title', 'Kirim Pengingat')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-900">Buat Pengingat Baru</h1>
            <p class="mt-2 text-sm text-gray-600">Isi form di bawah ini untuk membuat pengingat baru</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <form action="{{ route('user.form_pengingat.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6 sm:p-8">
                @csrf

                <!-- Two Column Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- User Selection -->
                        <div class="form-group">
                            <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 mr-3">
                                    <i class="fas fa-users text-blue-600"></i>
                                </div>
                                User yang dituju
                            </label>
                            <div class="relative">
                                <select id="user" name="user_ids[]" multiple
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm appearance-none bg-white">
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                            @error('user_ids')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Category Selection -->
                        <div class="form-group">
                            <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 mr-3">
                                    <i class="fas fa-tag text-blue-600"></i>
                                </div>
                                Sifat Surat
                            </label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach(['biasa', 'penting', 'kilat', 'rahasia', 'segera'] as $sifat)
                                <label
                                    class="relative flex items-center p-3 rounded-xl border border-gray-200 cursor-pointer hover:border-blue-500 transition-colors duration-200">
                                    <input type="radio" name="kategori" value="{{ $sifat }}"
                                        {{ old('kategori') == $sifat ? 'checked' : '' }} class="sr-only peer">
                                    <div class="flex items-center justify-center w-full">
                                        <span class="text-sm font-medium text-gray-700">{{ ucfirst($sifat) }}</span>
                                    </div>
                                    <div
                                        class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-blue-500 pointer-events-none">
                                    </div>
                                </label>
                                @endforeach
                            </div>
                            @error('kategori')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Disposition Selection -->
                        <div class="form-group">
                            <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 mr-3">
                                    <i class="fas fa-tasks text-blue-600"></i>
                                </div>
                                Disposisi Surat
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach(['diselesaikan', 'diperhatikan/monitor', 'dipedomani', 'diketahui', 'bahas
                                dengan saya'] as $disposisi)
                                <label
                                    class="relative flex items-center p-3 rounded-xl border border-gray-200 cursor-pointer hover:border-blue-500 transition-colors duration-200">
                                    <input type="checkbox" name="disposisi[]" value="{{ $disposisi }}"
                                        {{ in_array($disposisi, old('disposisi', [])) ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div class="flex items-center justify-center w-full">
                                        <span class="text-sm font-medium text-gray-700">{{ ucfirst($disposisi) }}</span>
                                    </div>
                                    <div
                                        class="absolute inset-0 rounded-xl border-2 border-transparent peer-checked:border-blue-500 pointer-events-none">
                                    </div>
                                </label>
                                @endforeach
                            </div>
                            @error('disposisi')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Date Selection -->
                        <div class="form-group">
                            <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 mr-3">
                                    <i class="fas fa-calendar text-blue-600"></i>
                                </div>
                                Tanggal Deadline
                            </label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            @error('tanggal')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Text Input -->
                        <div class="form-group">
                            <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 mr-3">
                                    <i class="fas fa-comment text-blue-600"></i>
                                </div>
                                Text (optional)
                            </label>
                            <textarea name="text" rows="4"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                placeholder="Masukkan teks pengingat...">{{ old('text') }}</textarea>
                            @error('text')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- File Upload -->
                        <div class="form-group">
                            <label class="flex items-center text-sm font-medium text-gray-700 mb-2">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 mr-3">
                                    <i class="fas fa-file-upload text-blue-600"></i>
                                </div>
                                File document
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-500 transition-colors duration-200 cursor-pointer"
                                onclick="document.getElementById('file').click()">
                                <div id="file-name" class="text-gray-500">
                                    <i class="fas fa-cloud-upload-alt text-3xl mb-3"></i>
                                    <p class="text-sm font-medium">Klik untuk memilih file</p>
                                    <p class="text-xs text-gray-400 mt-1">Format yang didukung: PDF, DOC, DOCX</p>
                                </div>
                            </div>
                            <input type="file" id="file" name="file" class="hidden"
                                onchange="document.getElementById('file-name').innerHTML = this.files[0] ? `<i class='fas fa-file text-3xl mb-3'></i><p class='text-sm font-medium'>${this.files[0].name}</p><p class='text-xs text-gray-400 mt-1'>Format yang didukung: PDF, DOC, DOCX</p>` : `<i class='fas fa-cloud-upload-alt text-3xl mb-3'></i><p class='text-sm font-medium'>Klik untuk memilih file</p><p class='text-xs text-gray-400 mt-1'>Format yang didukung: PDF, DOC, DOCX</p>`">
                            @error('file')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row justify-end gap-4">
                    <a href="{{ route('user.dashboard') }}"
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                    <button type="button" onclick="clearForm()"
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-times mr-2"></i>
                        Clear
                    </button>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-xl text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
function clearForm() {
    // Clear file input
    document.getElementById('file').value = '';
    document.getElementById('file-name').innerHTML = `
        <i class="fas fa-cloud-upload-alt text-3xl mb-3"></i>
        <p class="text-sm font-medium">Klik untuk memilih file</p>
        <p class="text-xs text-gray-400 mt-1">Format yang didukung: PDF, DOC, DOCX</p>
    `;

    // Clear user selection
    $('#user').val(null).trigger('change');

    // Clear radio buttons
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.checked = false;
    });

    // Clear checkboxes
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.checked = false;
    });

    // Clear date input
    document.querySelector('input[type="date"]').value = '';

    // Clear textarea
    document.querySelector('textarea').value = '';
}

// Inisialisasi Select2
$(document).ready(function() {
    $('#user').select2({
        placeholder: 'Cari dan pilih user...',
        allowClear: true,
        width: '100%',
        language: {
            noResults: function() {
                return "User tidak ditemukan";
            }
        }
    });
});
</script>
@endpush

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
/* Custom Select Styling */
select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-image: none;
}

select:focus {
    outline: none;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
}

select option {
    padding: 0.5rem 1rem;
}

select option:checked {
    background-color: #3b82f6;
    color: white;
}

select option:hover {
    background-color: #e5e7eb;
}

/* Select2 Custom Styling */
.select2-container--default .select2-selection--multiple {
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    min-height: 42px;
    padding: 0.25rem;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #3b82f6;
    border: 1px solid #2563eb;
    color: white;
    border-radius: 9999px;
    padding: 0.25rem 0.5rem;
    margin: 0.25rem;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: white;
    margin-right: 0.5rem;
}

.select2-container--default .select2-search--inline .select2-search__field {
    margin-top: 0.5rem;
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #3b82f6;
}
</style>
@endpush