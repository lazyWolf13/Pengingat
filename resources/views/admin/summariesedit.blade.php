@extends('layouts.dashboard')

@section('title', 'Edit Attendance Summary')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold mb-4">Edit Attendance Summary</h1>

    <form action="{{ route('summaries.update', $attendanceSummary->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="user_id" class="block">User ID</label>
            <input type="text" name="user_id" id="user_id" class="border rounded w-full p-2" value="{{ $attendanceSummary->user_id }}" required>
        </div>
        <div class="mb-4">
            <label for="bulan" class="block">Month</label>
            <input type="number" name="bulan" id="bulan" class="border rounded w-full p-2" value="{{ $attendanceSummary->bulan }}" required>
        </div>
        <div class="mb-4">
            <label for="tahun" class="block">Year</label>
            <input type="number" name="tahun" id="tahun" class="border rounded w-full p-2" value="{{ $attendanceSummary->tahun }}" required>
        </div>
        <div class="mb-4">
            <label for="total_hadir" class="block">Total Present</label>
            <input type="number" name="total_hadir" id="total_hadir" class="border rounded w-full p-2" value="{{ $attendanceSummary->total_hadir }}" required>
        </div>
        <div class="mb-4">
            <label for="total_terlambat" class="block">Total Late</label>
            <input type="number" name="total_terlambat" id="total_terlambat" class="border rounded w-full p-2" value="{{ $attendanceSummary->total_terlambat }}" required>
        </div>
        <div class="mb-4">
            <label for="total_lembur" class="block">Total Overtime</label>
            <input type="time" name="total_lembur" id="total_lembur" class="border rounded w-full p-2" value="{{ $attendanceSummary->total_lembur }}">
        </div>
        <div class="mb-4">
            <label for="total_izin" class="block">Total Permission</label>
            <input type="number" name="total_izin" id="total_izin" class="border rounded w-full p-2" value="{{ $attendanceSummary->total_izin }}" required>
        </div>
        <div class="mb-4">
            <label for="total_cuti" class="block">Total Leave</label>
            <input type="number" name="total_cuti" id="total_cuti" class="border rounded w-full p-2" value="{{ $attendanceSummary->total_cuti }}" required>
        </div>
        <div class="mb-4">
            <label for="admin_id" class="block">Admin ID</label>
            <input type="text" name="admin_id" id="admin_id" class="border rounded w-full p-2" value="{{ $attendanceSummary->admin_id }}">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Summary</button>
    </form>
</div>
@endsection 