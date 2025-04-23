@extends('layouts.dashboard')

@section('content')
    <style>
        .header {
            background: linear-gradient(135deg, #4a90e2, #357ab8);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .table-container {
            background-color: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }
        .table thead {
            background-color: #f8fafc;
        }
        .table th {
            padding: 12px;
            text-align: center;
            border-bottom: 2px solid #e2e8f0;
            font-weight: 600;
            color: #4a5568;
        }
        .table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }
        .table tbody tr:last-child td {
            border-bottom: none;
        }
        .table tbody tr:hover {
            background-color: #f8fafc;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }
        .status-menunggu {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-disetujui {
            background-color: #dcfce7;
            color: #166534;
        }
        .status-ditolak {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
        }
        .btn-view {
            background-color: #4a90e2;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 80px;
        }
        .btn-view:hover {
            background-color: #357ab8;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-delete {
            background-color: #e94e77;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 80px;
        }
        .btn-delete:hover {
            background-color: #d43d66;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="header">
        <div>
            <h1>Daftar Permohonan Izin/Cuti</h1>
        </div>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Karyawan</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Jenis</th>
                    <th>Status</th>
                    <th>Disetujui Oleh</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leaveRequests as $request)
                    <tr>
                        <td>{{ $request->id }}</td>
                        <td>{{ $request->user->full_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($request->tanggal_mulai)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($request->tanggal_selesai)->format('d/m/Y') }}</td>
                        <td>{{ ucfirst($request->jenis) }}</td>
                        <td>
                            <span class="status-badge status-{{ $request->status }}">
                                {{ ucfirst($request->status) }}
                            </span>
                        </td>
                        <td>{{ $request->approved_by ?? '-' }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.leavereq.show', $request->id) }}" class="btn-view">Lihat</a>
                                @if($request->status == 'menunggu')
                                    <form action="{{ route('admin.leavereq.destroy', $request->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus permohonan ini?')">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection 