@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-6 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-lg p-8 mb-8">
            <div class="text-white">
                <h2 class="text-3xl font-bold mb-2">
                    <i class="fas fa-user-edit mr-3"></i>Edit Admin User
                </h2>
                <p class="text-lg opacity-90">Perbarui data admin user</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
            <form action="{{ route('admin.adminusers.update', $adminuser->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Nama Lengkap -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user text-blue-500 mr-2"></i>Nama Lengkap
                    </label>
                    <input type="text" 
                           name="full_name" 
                           value="{{ old('full_name', $adminuser->full_name) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('full_name') border-red-500 @enderror"
                           placeholder="Masukkan nama lengkap">
                    @error('full_name')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope text-blue-500 mr-2"></i>Email
                    </label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email', $adminuser->email) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('email') border-red-500 @enderror"
                           placeholder="Masukkan email">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock text-blue-500 mr-2"></i>Password
                    </label>
                    <div class="relative">
                        <input type="password" 
                               name="password" 
                               id="password"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('password') border-red-500 @enderror"
                               placeholder="Kosongkan jika tidak ingin mengubah password">
                        <button type="button" 
                                onclick="togglePassword()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Kosongkan jika tidak ingin mengubah password
                    </p>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('admin.adminusers.index') }}" 
                       class="inline-flex items-center px-6 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transform hover:-translate-y-1 transition-all duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transform hover:-translate-y-1 transition-all duration-200">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const icon = document.querySelector('.fa-eye, .fa-eye-slash');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Animasi untuk form validation
document.querySelectorAll('input').forEach(input => {
    input.addEventListener('focus', function() {
        this.closest('.mb-6').classList.add('scale-105');
        this.classList.add('shadow-lg');
    });

    input.addEventListener('blur', function() {
        this.closest('.mb-6').classList.remove('scale-105');
        this.classList.remove('shadow-lg');
    });
});
</script>

<style>
/* Transisi halus untuk semua elemen */
* {
    transition: all 0.2s ease-in-out;
}

/* Efek hover untuk input */
input:hover {
    border-color: #93C5FD;
}

/* Animasi untuk error messages */
.text-red-600 {
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

/* Style untuk form groups */
.mb-6 {
    transition: transform 0.2s ease-in-out;
}

/* Custom focus styles */
input:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Button hover effects */
button:hover, a:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
</style>
@endsection 