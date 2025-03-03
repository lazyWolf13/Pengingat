@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Header Section dengan Background -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-lg p-6 mb-6 text-white">
        <h2 class="text-2xl font-bold mb-2">
            <i class="fas fa-user-edit mr-2"></i>Edit Profil
        </h2>
        <p class="opacity-80">Lengkapi informasi di bawah untuk memperbarui profil</p>
    </div>

    <!-- Form Card dengan Grid Layout -->
    <div class="card shadow-xl border-0 rounded-xl">
        <div class="card-body p-6">
            <form action="{{ route('admin.profiles.update', $profile->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 gap-6">
                    <!-- Judul -->
                    <div class="form-group">
                        <label for="judul" class="form-label text-gray-700 font-semibold mb-2 flex items-center">
                            <i class="fas fa-heading text-blue-500 mr-2"></i>Judul
                        </label>
                        <input type="text" 
                               class="form-control @error('judul') is-invalid @enderror" 
                               id="judul" 
                               name="judul" 
                               value="{{ old('judul', $profile->judul) }}"
                               placeholder="Masukkan judul" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Isi -->
                    <div class="form-group">
                        <label for="isi" class="form-label text-gray-700 font-semibold mb-2 flex items-center">
                            <i class="fas fa-file-alt text-blue-500 mr-2"></i>Isi
                        </label>
                        <textarea name="isi" 
                                  id="isi" 
                                  class="form-control @error('isi') is-invalid @enderror" 
                                  placeholder="Masukkan isi" required>{{ old('isi', $profile->isi) }}</textarea>
                        @error('isi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Buttons - Centered at bottom -->
                <div class="flex justify-center gap-4 mt-8">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>Update Profile
                    </button>
                    <a href="{{ route('admin.profiles.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .form-control {
        border-radius: 8px;
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        width: 100%;
        background-color: #f8fafc;
    }

    .form-control:focus {
        border-color: #4F46E5;
        box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
        background-color: white;
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    .btn {
        padding: 0.75rem 2rem;
        border-radius: 9999px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-primary {
        background-color: #4F46E5;
        color: white;
        border: none;
    }

    .btn-primary:hover {
        background-color: #4338CA;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .btn-secondary {
        background-color: #94a3b8;
        color: white;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #64748b;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .invalid-feedback {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .form-label {
        font-size: 0.875rem;
        color: #4b5563;
    }

    @media (max-width: 768px) {
        .grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Tambahkan Font Awesome jika belum ada -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection 