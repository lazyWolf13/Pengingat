@extends('layouts.dashboarduser')

@section('content')
<div class="container-fluid px-6 py-8">
    <div class="max-w-6xl mx-auto">

        <!-- Form Card dengan Shadow & Animation -->
        <div
            class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 hover:shadow-xl transition-all duration-300">
            <form action="{{ route('user.form_pengingat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div>
                        <!-- User yang dituju -->
                        <div class="form-group transform transition-all duration-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <div class="flex items-center">
                                    <div class="bg-blue-50 p-2 rounded-lg mr-2">
                                        <i class="fas fa-users text-blue-500"></i>
                                    </div>
                                    User yang dituju
                                </div>
                            </label>
                            <select id="user" name="user_ids[]" multiple="multiple"
                                class="user-select w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                <option></option> <!-- untuk placeholder kosong -->
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                @endforeach

                            </select>
                            @error('user_ids')
                            <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>


                        <!-- Sifat Surat -->
                        <div class="form-group transform transition-all duration-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <div class="flex items-center">
                                    <div class="bg-blue-50 p-2 rounded-lg mr-2">
                                        <i class="fas fa-tag text-blue-500"></i>
                                    </div>
                                    Sifat Surat
                                </div>
                            </label>
                            <div class="space-y-2 bg-white p-4 rounded-lg border border-gray-200">
                                @foreach(['biasa', 'penting', 'kilat', 'rahasia', 'segera'] as $sifat)
                                <label
                                    class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                                    <input type="radio" name="kategori" value="{{ $sifat }}"
                                        {{ old('kategori') == $sifat ? 'checked' : '' }}
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="text-gray-700">{{ ucfirst($sifat) }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('kategori')
                            <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Disposisi Surat -->
                        <div class="form-group transform transition-all duration-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <div class="flex items-center">
                                    <div class="bg-blue-50 p-2 rounded-lg mr-2">
                                        <i class="fas fa-tasks text-blue-500"></i>
                                    </div>
                                    Disposisi Surat
                                </div>
                            </label>
                            <div class="space-y-2 bg-white p-4 rounded-lg border border-gray-200">
                                @foreach(['diselesaikan', 'diperhatikan/monitor', 'dipedomani', 'diketahui', 'bahas
                                dengan saya'] as $disposisi)
                                <label
                                    class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer">
                                    <input type="checkbox" name="disposisi[]" value="{{ $disposisi }}"
                                        {{ in_array($disposisi, old('disposisi', [])) ? 'checked' : '' }}
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <span class="text-gray-700">{{ ucfirst($disposisi) }}</span>
                                </label>
                                @endforeach
                            </div>
                            @error('disposisi')
                            <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div>
                        <!-- Tanggal -->
                        <div class="form-group transform transition-all duration-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <div class="flex items-center">
                                    <div class="bg-blue-50 p-2 rounded-lg mr-2">
                                        <i class="fas fa-calendar text-blue-500"></i>
                                    </div>
                                    Tanggal
                                </div>
                            </label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            @error('tanggal')
                            <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>


                        <!-- Text -->
                        <div class="form-group transform transition-all duration-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <div class="flex items-center">
                                    <div class="bg-blue-50 p-2 rounded-lg mr-2">
                                        <i class="fas fa-comment text-blue-500"></i>
                                    </div>
                                    Text (optional)
                                </div>
                            </label>
                            <textarea name="text"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                placeholder="Text (optional)">{{ old('text') }}</textarea>
                            @error('text')
                            <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- File Upload -->
                        <div class="form-group transform transition-all duration-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <div class="flex items-center">
                                    <div class="bg-blue-50 p-2 rounded-lg mr-2">
                                        <i class="fas fa-file-upload text-blue-500"></i>
                                    </div>
                                    File document
                                </div>
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition-all duration-200 cursor-pointer"
                                onclick="document.getElementById('file').click()">
                                <div id="file-name" class="text-gray-500">
                                    <i class="fas fa-cloud-upload-alt text-3xl mb-2"></i>
                                    <p>Klik untuk memilih file</p>
                                </div>
                            </div>
                            <input type="file" id="file" name="file" class="hidden" onchange="displayFileName()">
                            @error('file')
                            <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" onclick="clearFile()"
                                class="inline-flex items-center px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transform hover:-translate-y-1 transition-all duration-200 hover:shadow text-sm">
                                <i class="fas fa-times mr-2"></i>
                                Clear
                            </button>
                            <button type="submit"
                                class="inline-flex items-center px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transform hover:-translate-y-1 transition-all duration-200 hover:shadow text-sm">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Kirim
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: "Pilih user",
        allowClear: true,
        width: '100%',
        language: {
            noResults: function() {
                return "Tidak ada hasil yang ditemukan";
            },
            searching: function() {
                return "Mencari...";
            }
        }
    });

    // Set today's date as default
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];
    $('input[type="date"]').val(formattedDate);
});

function displayFileName() {
    const input = document.getElementById('file');
    const fileName = input.files[0] ? input.files[0].name : 'Klik untuk memilih file';
    document.getElementById('file-name').innerHTML = `
        <i class="fas fa-file text-3xl mb-2"></i>
        <p>${fileName}</p>
    `;
}

function clearFile() {
    document.getElementById('file').value = '';
    document.getElementById('file-name').innerHTML = `
        <i class="fas fa-cloud-upload-alt text-3xl mb-2"></i>
        <p>Klik untuk memilih file</p>
    `;
}

// Form Group Animation
document.querySelectorAll('.form-group').forEach(group => {
    const input = group.querySelector('input, select, textarea');

    if (input) {
        input.addEventListener('focus', () => {
            group.classList.add('scale-[1.02]');
        });

        input.addEventListener('blur', () => {
            group.classList.remove('scale-[1.02]');
        });
    }
});
</script>

<style>
/* Smooth transitions */
* {
    transition: all 0.2s ease-in-out;
}

/* Input hover effect */
input:hover,
select:hover,
textarea:hover {
    border-color: #93C5FD;
}

/* Error message animation */
@keyframes shake {

    0%,
    100% {
        transform: translateX(0);
    }

    25% {
        transform: translateX(-5px);
    }

    75% {
        transform: translateX(5px);
    }
}

.text-red-600 {
    animation: shake 0.5s ease-in-out;
}

/* Form group hover effect */
.form-group:hover {
    transform: translateX(5px);
}

/* Custom focus ring */
input:focus,
select:focus,
textarea:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Button hover animation */
button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Card hover effect */
.rounded-xl:hover {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Select2 customization */
.select2-container--default .select2-selection--multiple {
    border: 1px solid #e5e7eb !important;
    border-radius: 0.5rem !important;
    padding: 0.25rem !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #e5e7eb !important;
    border: none !important;
    color: #374151 !important;
    border-radius: 0.25rem !important;
    padding: 0.25rem 0.5rem !important;
    margin: 0.25rem !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: #6b7280 !important;
    margin-right: 0.5rem !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
    color: #ef4444 !important;
    background: none !important;
}
</style>
@endpush

@endsection
=======
@section('title', 'Pengingat')

@section('content')
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Pengingat</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body class="bg-gradient-to-br from-green-300 via-green-400 to-green-500 min-h-screen flex items-center justify-center relative">
    <!-- Tombol Kembali -->
    <a href="http://127.0.0.1:8000"
        class="absolute top-4 left-4 p-2 rounded-full bg-white bg-opacity-80 hover:bg-opacity-100 shadow-md transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
    </a>

    <div class="bg-green-50 bg-opacity-90 p-8 rounded-lg shadow-lg w-[900px] flex gap-8 border border-green-200">
        <!-- Isi Form Pengingat -->
        <form action="#" method="POST" class="w-full space-y-6">
            @csrf
            <div>
                <label for="judul" class="block mb-2 text-sm font-medium text-green-900">Judul Pengingat</label>
                <input type="text" id="judul" name="judul"
                    class="bg-white border border-green-300 text-green-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
            </div>

            <div>
                <label for="tanggal" class="block mb-2 text-sm font-medium text-green-900">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal"
                    class="bg-white border border-green-300 text-green-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
            </div>

            <div>
                <label for="deskripsi" class="block mb-2 text-sm font-medium text-green-900">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4"
                    class="bg-white border border-green-300 text-green-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                    required></textarea>
            </div>

            <div>
                <label for="kategori" class="block mb-2 text-sm font-medium text-green-900">Kategori</label>
                <select id="kategori" name="kategori"
                    class="select2 bg-white border border-green-300 text-green-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                    <option value="">Pilih Kategori</option>
                    <option value="Pekerjaan">Pekerjaan</option>
                    <option value="Penting">Penting</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <button type="submit"
                class="w-full bg-green-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-700 transition-all">
                Simpan Pengingat
            </button>
        </form>
    </div>

    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
</body>

</html>
@endsection
