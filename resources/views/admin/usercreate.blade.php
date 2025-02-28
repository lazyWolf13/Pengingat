@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-4 py-5">
    <!-- Header Section dengan Background -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-lg p-6 mb-6 text-white">
        <h2 class="text-2xl font-bold mb-2">
            <i class="fas fa-user-plus mr-2"></i>Tambah User Baru
        </h2>
        <p class="opacity-80">Lengkapi informasi di bawah untuk menambahkan user baru ke sistem</p>
    </div>

    <!-- Form Card dengan Grid Layout -->
    <div class="card shadow-xl border-0 rounded-xl">
        <div class="card-body p-6">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-4">
                        <!-- Nama Lengkap -->
                        <div class="form-group">
                            <label for="full_name" class="form-label text-gray-700 font-semibold mb-2 flex items-center">
                                <i class="fas fa-user text-blue-500 mr-2"></i>Nama Lengkap
                            </label>
                            <input type="text" 
                                   class="form-control @error('full_name') is-invalid @enderror" 
                                   id="full_name" 
                                   name="full_name" 
                                   value="{{ old('full_name') }}"
                                   placeholder="Masukkan nama lengkap">
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email" class="form-label text-gray-700 font-semibold mb-2 flex items-center">
                                <i class="fas fa-envelope text-blue-500 mr-2"></i>Email
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   placeholder="contoh@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password" class="form-label text-gray-700 font-semibold mb-2 flex items-center">
                                <i class="fas fa-lock text-blue-500 mr-2"></i>Password
                            </label>
                            <div class="input-group">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password"
                                       placeholder="Masukkan password">
                                <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-4">
                        <!-- Subdit -->
                        <div class="form-group">
                            <label for="subdit" class="form-label text-gray-700 font-semibold mb-2 flex items-center">
                                <i class="fas fa-building text-blue-500 mr-2"></i>Subdit
                            </label>
                            <input type="text" 
                                   class="form-control @error('subdit') is-invalid @enderror" 
                                   id="subdit" 
                                   name="subdit" 
                                   value="{{ old('subdit') }}"
                                   placeholder="Masukkan subdit">
                            @error('subdit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Lembaga -->
                        <div class="form-group">
                            <label for="lembaga" class="form-label text-gray-700 font-semibold mb-2 flex items-center">
                                <i class="fas fa-university text-blue-500 mr-2"></i>Lembaga
                            </label>
                            <input type="text" 
                                   class="form-control @error('lembaga') is-invalid @enderror" 
                                   id="lembaga" 
                                   name="lembaga" 
                                   value="{{ old('lembaga') }}"
                                   placeholder="Masukkan lembaga">
                            @error('lembaga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Buttons - Centered at bottom -->
                <div class="flex justify-center gap-4 mt-8">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>Simpan Data
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
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

    .input-group {
        display: flex;
        position: relative;
    }

    .input-group .btn {
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        border-radius: 0 8px 8px 0;
        padding: 0 1rem;
        background-color: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-left: none;
    }

    .input-group .btn:hover {
        background-color: #e2e8f0;
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

<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const password = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>

<!-- Tambahkan Font Awesome jika belum ada -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection 