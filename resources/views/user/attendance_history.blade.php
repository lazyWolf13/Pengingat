
@extends('layouts.dashboarduser')
@section('title', 'Riwayat Absensi')
@section('content')
<div class="bg-white shadow-lg rounded-lg p-6 mb-4">
    <h2 class="text-lg font-semibold mb-4">📜 Riwayat Absensi</h2>
    
    <div class="overflow-x-auto">
        <table id="attendanceTable" class="w-full border border-gray-200 rounded-lg text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">No</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Keterangan</th>
                    <th class="p-3">Check-In</th>
                    <th class="p-3">Check-Out</th>
                    <th class="p-3">Status Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $index => $attendance)
                    <tr class="border-t">
                        <td class="p-3">{{ $index + 1 }}</td>
                        <td class="p-3">{{ $attendance->waktu_check_in->format('d-m-Y') }}</td>
                        <td class="p-3 font-semibold 
                            @if(strtolower($attendance->status) == 'hadir') text-green-600
                            @elseif(strtolower($attendance->status) == 'sakit') text-yellow-500
                            @elseif(strtolower($attendance->status) == 'izin') text-blue-500
                            @else text-red-600 @endif">
                            {{ $attendance->status }}
                        </td>
                        <td class="p-3">{{ $attendance->waktu_check_in ? $attendance->waktu_check_in->format('H:i') : '-' }}</td>
                        <td class="p-3">{{ $attendance->waktu_check_out ? $attendance->waktu_check_out->format('H:i') : '-' }}</td>
                        <td class="p-3 font-semibold 
                            @if($attendance->waktu_check_in->format('H:i') <= '07:30') text-green-600 @else text-red-600 @endif">
                            {{ $attendance->waktu_check_in->format('H:i') <= '07:30' ? 'Tepat Waktu' : 'Terlambat' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('filterYear').addEventListener('change', function () {
            let year = this.value;
            window.location.href = `?year=${year}`;
        });
        
        document.getElementById('reload').addEventListener('click', function () {
            location.reload();
        });
    });
</script>
@endsection
