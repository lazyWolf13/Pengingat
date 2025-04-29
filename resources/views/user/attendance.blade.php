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

    {{-- Waktu --}}
    <p><strong>⏳ Waktu:</strong> 
        @if($attendance && $attendance->waktu_check_in)
            <span class="font-semibold">{{ \Carbon\Carbon::parse($attendance->waktu_check_in)->format('H:i') }}</span>
        @else
            <span class="text-gray-500">-</span>
        @endif
    </p>

    {{-- Status Absen --}}
    <p><strong>📌 Status Absen:</strong> 
        @if($attendance)
            <span class="text-green-600 font-semibold">✅ Absen Masuk</span>
        @else
            <span class="text-red-600 font-semibold">❌ Belum Absen</span>
        @endif
    </p>

    {{-- Keterangan --}}
    <p><strong>📩 Keterangan:</strong> 
        @if($attendance && $attendance->waktu_check_in)
            @if(\Carbon\Carbon::parse($attendance->waktu_check_in)->format('H:i') > '08:30')
                <span class="text-red-600 font-semibold">⏰ Terlambat</span>
            @else
                <span class="text-green-600 font-semibold">✔ Tepat Waktu</span>
            @endif
        @else
            <span class="text-gray-500">-</span>
        @endif
    </p>
</div>

    <div class="mt-3 flex justify-start">
        @if(!$attendance)
        <button 
            id="cekLokasiAbsen"
            class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 w-full max-w-[200px]">
            🚀 Absen Masuk
        </button>
        @endif

        @if($attendance)
            <form action="{{ route('user.absen.pulang') }}" method="POST" class="mt-3 flex justify-start" id="absenPulangForm">
                @csrf
                <input type="hidden" name="local_check_out" id="local_check_out">
                <button type="submit" 
                    id="btnAbsenPulang"
                    class="px-6 py-2 rounded-lg 
                    @if($attendance->status == 'hadir' && !$attendance->waktu_check_out) bg-blue-500 hover:bg-blue-600 text-white @else bg-gray-400 cursor-not-allowed @endif"
                    @if($attendance->status != 'hadir' || $attendance->waktu_check_out) disabled @endif
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
                <option value="Izin">Izin</option>
                <option value="Cuti">Cuti</option>
            </select>

            <input type="hidden" name="local_time" id="local_time">
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">
            <input type="hidden" name="lokasi_absen" id="lokasi_absen">

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

<!-- Modal Warning Belum Waktunya Pulang -->
<div id="belumWaktuModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
        <h2 class="text-xl font-bold mb-4 text-yellow-600">⏳ Belum Waktunya Pulang</h2>
        <p class="mb-4">Kamu hanya bisa absen pulang setelah jam 16:00 WIB.</p>
        <button id="closeBelumWaktuModal" class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600">
            OK
        </button>
    </div>
</div>

<!-- Modal Warning Jika di luar jangkauan -->
<div id="warningModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
        <h2 class="text-xl font-bold mb-4 text-red-600">⚠ Tidak Bisa Absen</h2>
        <p class="mb-4">Kamu berada di luar jangkauan lokasi absen. Silakan berada di area yang diperbolehkan untuk melakukan absen.</p>
        <button id="closeWarningModal" class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600">
            OK
        </button>
    </div>
</div>

<script>

document.getElementById("cancelAbsenMasuk").addEventListener("click", function() {
    document.getElementById("absenModal").classList.add("hidden");
});


document.getElementById("absenMasukForm").addEventListener("submit", function(event) {
    event.preventDefault(); // prevent submit sampai dapat lokasi

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            let now = new Date();
            let formattedTime = now.getFullYear() + '-' + 
                ('0' + (now.getMonth() + 1)).slice(-2) + '-' + 
                ('0' + now.getDate()).slice(-2) + ' ' + 
                ('0' + now.getHours()).slice(-2) + ':' + 
                ('0' + now.getMinutes()).slice(-2) + ':' + 
                ('0' + now.getSeconds()).slice(-2);

                

            document.getElementById("local_time").value = formattedTime;
            document.getElementById("latitude").value = position.coords.latitude;
            document.getElementById("longitude").value = position.coords.longitude;
            document.getElementById("lokasi_absen").value = position.coords.latitude + ',' + position.coords.longitude;


            // submit form setelah semua data terisi
            document.getElementById("absenMasukForm").submit();
        }, function(error) {
            alert("Gagal mengambil lokasi. Izinkan akses lokasi di browser Anda.");
        });
    } else {
        alert("Browser tidak mendukung geolokasi.");
    }
});


    const lokasiAbsen = { lat: -6.6027276535294, lng: 106.79819226264955 }; // Titik lokasi tetap (misalnya lokasi sekolah)
    const batasRadius = 300; // meter

    function getDistanceFromLatLonInMeters(lat1, lon1, lat2, lon2) {
        const R = 6371000; // Radius bumi dalam meter
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a =
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
            Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c; // Distance in meters
    }

    const cekBtn = document.getElementById("cekLokasiAbsen");
    if (cekBtn) {
        cekBtn.addEventListener("click", function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    const distance = getDistanceFromLatLonInMeters(userLat, userLng, lokasiAbsen.lat, lokasiAbsen.lng);

                    if (distance <= batasRadius) {
                        // Di dalam radius: buka form absen
                        document.getElementById("absenModal").classList.remove("hidden");
                    } else {
                        // Di luar radius: tampilkan modal warning
                        document.getElementById("warningModal").classList.remove("hidden");
                    }
                }, function(error) {
                    alert("Gagal mengambil lokasi. Izinkan akses lokasi di browser Anda.");
                });
            } else {
                alert("Browser tidak mendukung geolokasi.");
            }
    })};

    document.getElementById("closeWarningModal").addEventListener("click", function() {
        document.getElementById("warningModal").classList.add("hidden");
    });

    document.addEventListener("DOMContentLoaded", function() {
    let form = document.getElementById("absenPulangForm");

    if (form) { // Pastikan form ada sebelum menambahkan event listener
        form.addEventListener("submit", function(e) {
            console.log("Form submit sedang diproses...");
            e.preventDefault(); // cegah submit langsung

            let now = new Date();
            let jam = now.getHours();

            if (jam >= 16) {
                let formattedTime = now.toISOString();
                document.getElementById("local_check_out").value = formattedTime;
                console.log("Waktu Check-out yang Dikirim: ", formattedTime);
                e.target.submit();
            } else {
                document.getElementById("belumWaktuModal").classList.remove("hidden");
            }
        });

    } else {
        console.log("Form tidak ditemukan di halaman.");
    }
});

document.getElementById("closeBelumWaktuModal").addEventListener("click", function() {
    document.getElementById("belumWaktuModal").classList.add("hidden");
});

    
</script>
@endsection