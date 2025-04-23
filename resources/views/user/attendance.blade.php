@extends('layouts.dashboarduser')
@section('title', 'Absensi')
@section('content')
<div class="bg-white shadow-lg rounded-lg p-6 mb-4">
    <h2 class="text-lg font-semibold mb-4">📍 Absensi Hari Ini</h2>
    <div class="grid grid-cols-2 gap-4 text-gray-700">
        <p><strong>👤 Nama:</strong> {{ auth()->user()->full_name }}</p>
        <p><strong>📝 Absen:</strong> 
            @if($attendance)
                <span class="font-semibold">{{ $attendance->status }}</span>
            @else
                <span class="text-gray-500">-</span>
            @endif
        </p>
        <p><strong>📅 Tanggal:</strong> {{ now()->format('l, d F Y') }}</p>
        @if($attendance && $attendance->waktu_check_in)
            <p><strong>⏳ Waktu:</strong> 
                <span class="font-semibold">{{ \Carbon\Carbon::parse($attendance->waktu_check_in)->format('H:i') }}</span>
            </p>
        @endif
        <p><strong>📌 Status Absen:</strong> 
            @if($attendance)
                <span class="text-green-600 font-semibold">✅ Absen Masuk</span>
            @else
                <span class="text-red-600 font-semibold">❌ Belum Absen</span>
            @endif
        </p>
        
        @if($attendance && $attendance->waktu_check_in)
            <p><strong>📩 Keterangan:</strong> 
                @if(\Carbon\Carbon::parse($attendance->waktu_check_in)->format('H:i') > '08:30')
                    <span class="text-red-600 font-semibold">⏰ Terlambat</span>
                @else
                    <span class="text-green-600 font-semibold">✔ Tepat Waktu</span>
                @endif
            </p>
        @endif
    </div>
    <div class="mt-3 flex justify-start">
        @if(!$attendance)
            <button id="openAbsenModal" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 w-full max-w-[200px]">
                🚀 Absen Masuk
            </button>
        @endif
        @if($attendance)
            <form action="{{ route('user.absen.pulang') }}" method="POST" class="mt-3 flex justify-start">
                @csrf
                <button type="submit" 
                    id="btnAbsenPulang"
                    class="px-6 py-2 rounded-lg 
                    @if(now()->format('H') < 16 || $attendance->waktu_check_out) bg-gray-400 cursor-not-allowed @else bg-blue-500 hover:bg-blue-600 text-white @endif"
                    @if(now()->format('H') < 16 || $attendance->waktu_check_out) disabled @endif
                >
                    🏠 Absen Pulang
                </button>
            </form>
        @endif
    </div>
</div>

<!-- Modal Form Absen Masuk -->
<div id="absenModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4">📝 Isi Absen</h2>
        <form action="{{ route('user.absen.masuk') }}" method="POST" enctype="multipart/form-data" id="absenMasukForm">
            @csrf
            <label class="block mb-2">Status Absen:</label>
            <select name="status" id="statusAbsen" class="w-full border rounded p-2 mb-4">
                <option value="Hadir">Hadir</option>
                <option value="Sakit">Sakit</option>
                <option value="Izin">Izin</option>
                <option value="Cuti">Cuti</option>
            </select>

            <div id="uploadSection" class="hidden">
                <label class="block mb-2">Upload Surat (PDF/JPG/PNG):</label>
                <input type="file" name="file_surat" class="w-full border rounded p-2 mb-4">

                <label class="block mb-2">Keterangan:</label>
                <textarea name="keterangan" class="w-full border rounded p-2 mb-4"></textarea>
            </div>

            <input type="hidden" name="local_time" id="local_time">

            <div class="flex justify-end gap-2">
                <button type="button" id="cancelAbsenMasuk" class="bg-gray-400 text-white px-6 py-2 rounded-lg hover:bg-gray-500">
                    ❌ Cancel
                </button>
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600">
                    ✅ OK
                </button>
            </div>
        </form>
    </div>  
</div>

<!-- Modal Form Absen Pulang -->
<div id="absenPulangModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4">🏠 Absen Pulang</h2>
        <form action="{{ route('user.absen.pulang') }}" method="POST">
            @csrf
            <p class="mb-4">Apakah Anda yakin ingin absen pulang?</p>
            <button type="button" id="closeAbsenPulangModal" class="ml-2 text-gray-600 hover:text-gray-800">Batal</button>
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                🚪 Ya, Absen Pulang
            </button>
        </form>
    </div>
</div>

<script>
document.getElementById("openAbsenModal").addEventListener("click", function() {
    document.getElementById("absenModal").classList.remove("hidden");
});

document.getElementById("cancelAbsenMasuk").addEventListener("click", function() {
    document.getElementById("absenModal").classList.add("hidden");
});

document.getElementById("statusAbsen").addEventListener("change", function() {
    let uploadSection = document.getElementById("uploadSection");
    if (["Sakit", "Izin", "Cuti"].includes(this.value)) {
        uploadSection.classList.remove("hidden");
    } else {
        uploadSection.classList.add("hidden");
    }
});

document.getElementById("absenMasukForm").addEventListener("submit", function() {
    let now = new Date();
    let formattedTime = now.getFullYear() + '-' + 
        ('0' + (now.getMonth() + 1)).slice(-2) + '-' + 
        ('0' + now.getDate()).slice(-2) + ' ' + 
        ('0' + now.getHours()).slice(-2) + ':' + 
        ('0' + now.getMinutes()).slice(-2) + ':' + 
        ('0' + now.getSeconds()).slice(-2);
    document.getElementById("local_time").value = formattedTime;
});
</script>
@endsection
