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
        .form-container {
            background-color: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .info-group {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f8fafc;
            border-radius: 8px;
        }
        .info-group h3 {
            margin: 0 0 15px 0;
            color: #4a5568;
            font-size: 18px;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
        }
        .info-label {
            width: 150px;
            font-weight: 500;
            color: #4a5568;
        }
        .info-value {
            flex: 1;
            color: #2d3748;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            display: inline-block;
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
            gap: 12px;
            margin-top: 30px;
        }
        .btn-approve {
            background-color: #10b981;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            flex: 1;
        }
        .btn-reject {
            background-color: #ef4444;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            flex: 1;
        }
        .btn-approve:hover, .btn-reject:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-back {
            background-color: #4a90e2;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
            margin-bottom: 20px;
        }
        .btn-back:hover {
            background-color: #357ab8;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>

    <a href="{{ route('admin.leavereq.index') }}" class="btn-back">Kembali</a>

    <div class="header">
        <div>
            <h1>Detail Permohonan Izin/Cuti</h1>
        </div>
    </div>

    <div class="form-container">
        <div class="info-group">
            <h3>Informasi Karyawan</h3>
            <div class="info-row">
                <div class="info-label">Nama Karyawan</div>
                <div class="info-value">{{ $leaveRequest->user->full_name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $leaveRequest->user->email }}</div>
            </div>
        </div>

        <div class="info-group">
            <h3>Detail Permohonan</h3>
            <div class="info-row">
                <div class="info-label">Jenis</div>
                <div class="info-value">{{ ucfirst($leaveRequest->jenis) }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal Mulai</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($leaveRequest->tanggal_mulai)->format('d/m/Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal Selesai</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($leaveRequest->tanggal_selesai)->format('d/m/Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Status</div>
                <div class="info-value">
                    <span class="status-badge status-{{ $leaveRequest->status }}">
                        {{ ucfirst($leaveRequest->status) }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Keterangan</div>
                <div class="info-value">{{ $leaveRequest->keterangan ?? '-' }}</div>
            </div>
            @if($leaveRequest->approved_by)
                <div class="info-row">
                    <div class="info-label">Disetujui Oleh</div>
                    <div class="info-value">{{ $leaveRequest->approved_by }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tanggal Disetujui</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($leaveRequest->approved_at)->format('d/m/Y H:i') }}</div>
                </div>
            @endif
        </div>

        @if($leaveRequest->status == 'menunggu')
            <form action="{{ route('admin.leavereq.approve', $leaveRequest->id) }}" method="POST">
                @csrf
                <div class="action-buttons">
                    <button type="submit" name="status" value="disetujui" class="btn-approve">Setujui</button>
                    <button type="submit" name="status" value="ditolak" class="btn-reject">Tolak</button>
                </div>
            </form>
        @endif
    </div>
@endsection 