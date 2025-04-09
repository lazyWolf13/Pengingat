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
        .header a {
            background-color: #ffffff;
            color: #4a90e2;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .header a:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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
        .photo-preview {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .action-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            align-items: center;
        }
        .btn-edit {
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
        .btn-edit:hover {
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
            <h1>Daftar Foto</h1>
        </div>
        <a href="{{ route('admin.fotocreate.create') }}">Tambah Foto</a>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Foto</th>
                    <th>Judul</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fotos as $foto)
                    <tr>
                        <td>{{ $foto->id }}</td>
                        <td>
                            <img src="{{ $foto->file_url }}" alt="{{ $foto->judul }}" class="photo-preview">
                        </td>
                        <td>{{ $foto->judul }}</td>
                        <td>{{ $foto->catatan }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.fotoedit.edit', $foto->id) }}" class="btn-edit">Edit</a>
                                <form action="{{ route('admin.foto.destroy', $foto->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection