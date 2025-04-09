@extends('layouts.dashboard')

@section('content')
    <style>
        .form-header {
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
        .form-header h1 {
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
        .form-group {
            margin-bottom: 25px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
            font-size: 16px;
        }
        .form-control {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
            font-size: 14px;
            background-color: #f8fafc;
        }
        .form-control:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
            outline: none;
            background-color: white;
        }
        .btn-submit {
            background: linear-gradient(135deg, #4a90e2, #357ab8);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            width: 100%;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
        }
        .file-upload-container {
            border: 2px dashed #4a90e2;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 15px;
        }
        .file-upload-container:hover {
            background-color: #f0f7ff;
        }
        .file-upload-container input[type="file"] {
            display: none;
        }
        .file-upload-label {
            display: block;
            cursor: pointer;
        }
        .file-upload-icon {
            font-size: 48px;
            color: #4a90e2;
            margin-bottom: 10px;
        }
        .preview-container {
            margin-top: 20px;
            text-align: center;
        }
        .preview-image {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .textarea-control {
            min-height: 120px;
            resize: vertical;
        }
        .current-image {
            margin-bottom: 20px;
            text-align: center;
        }
        .current-image img {
            max-width: 300px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="form-header">
        <h1>Edit Foto</h1>
    </div>

    <div class="form-container">
        <form action="{{ route('admin.foto.update', $foto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label>Foto Saat Ini</label>
                <div class="current-image">
                    <img src="{{ $foto->file_url }}" alt="Current Photo" class="preview-image">
                </div>
            </div>

            <div class="form-group">
                <label for="file">Upload Foto Baru</label>
                <div class="file-upload-container">
                    <label class="file-upload-label">
                        <div class="file-upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <p>Klik atau drag file ke sini untuk upload</p>
                        <input type="file" name="file" id="file" class="form-control" accept="image/*">
                    </label>
                </div>
                <div class="preview-container" id="newPreview" style="display: none;">
                    <img id="preview" class="preview-image" src="#" alt="Preview">
                </div>
            </div>

            <div class="form-group">
                <label for="judul">Judul Foto</label>
                <input type="text" name="judul" id="judul" class="form-control" value="{{ $foto->judul }}" placeholder="Masukkan judul foto">
            </div>

            <div class="form-group">
                <label for="catatan">Catatan</label>
                <textarea name="catatan" id="catatan" class="form-control textarea-control" placeholder="Tambahkan catatan tentang foto ini">{{ $foto->catatan }}</textarea>
            </div>

            <button type="submit" class="btn-submit">Update Foto</button>
        </form>
    </div>

    <script>
        document.getElementById('file').addEventListener('change', function(e) {
            const previewContainer = document.getElementById('newPreview');
            const preview = document.getElementById('preview');
            const file = e.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
            }
        });
    </script>
@endsection