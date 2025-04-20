@extends('layouts.dashboarduser')

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
