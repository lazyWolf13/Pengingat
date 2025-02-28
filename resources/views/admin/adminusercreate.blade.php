@extends('layouts.dashboard')

@section('content')
<div class="container-fluid px-6 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section dengan Gradient & Shadow -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl shadow-lg p-8 mb-6 transform hover:scale-[1.01] transition-all duration-300">
            <div class="text-white">
                <h2 class="text-2xl font-bold mb-2 flex items-center">
                    <i class="fas fa-user-plus text-3xl mr-4 bg-white/20 p-3 rounded-lg"></i>
                    Tambah Admin User
                </h2>
                <p class="text-base opacity-90 ml-14">Tambahkan admin user baru ke sistem</p>
            </div>
        </div>

        <!-- Form Card dengan Shadow & Animation -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 hover:shadow-xl transition-all duration-300">
            <form action="{{ route('admin.adminusers.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 gap-6">
                    <!-- Nama Lengkap -->
                    <div class="form-group transform transition-all duration-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <div class="flex items-center">
                                <div class="bg-blue-50 p-2 rounded-lg mr-2">
                                    <i class="fas fa-user text-blue-500"></i>
                                </div>
                                Nama Lengkap
                            </div>
                        </label>
                        <input type="text" 
                               name="full_name" 
                               value="{{ old('full_name') }}"
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('full_name') border-red-500 @enderror"
                               placeholder="Masukkan nama lengkap">
                        @error('full_name')
                            <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group transform transition-all duration-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <div class="flex items-center">
                                <div class="bg-blue-50 p-2 rounded-lg mr-2">
                                    <i class="fas fa-envelope text-blue-500"></i>
                                </div>
                                Email
                            </div>
                        </label>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('email') border-red-500 @enderror"
                               placeholder="Masukkan email">
                        @error('email')
                            <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password dengan Toggle -->
                    <div class="form-group transform transition-all duration-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <div class="flex items-center">
                                <div class="bg-blue-50 p-2 rounded-lg mr-2">
                                    <i class="fas fa-lock text-blue-500"></i>
                                </div>
                                Password
                            </div>
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   name="password" 
                                   id="password"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('password') border-red-500 @enderror"
                                   placeholder="Masukkan password">
                            <button type="button" 
                                    onclick="togglePassword()"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none p-1.5 hover:bg-gray-100 rounded-full transition-all duration-200">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Buttons dengan Hover Effects -->
                <div class="flex justify-end space-x-3 mt-8">
                    <a href="{{ route('admin.adminusers.index') }}" 
                       class="inline-flex items-center px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transform hover:-translate-y-1 transition-all duration-200 hover:shadow text-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transform hover:-translate-y-1 transition-all duration-200 hover:shadow text-sm">
                        <i class="fas fa-save mr-2"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Toggle Password Visibility
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

// Form Group Animation
document.querySelectorAll('.form-group').forEach(group => {
    const input = group.querySelector('input');
    
    input.addEventListener('focus', () => {
        group.classList.add('scale-[1.02]');
    });
    
    input.addEventListener('blur', () => {
        group.classList.remove('scale-[1.02]');
    });
});
</script>

<style>
/* Smooth transitions */
* {
    transition: all 0.2s ease-in-out;
}

/* Input hover effect */
input:hover {
    border-color: #93C5FD;
}

/* Error message animation */
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.text-red-600 {
    animation: shake 0.5s ease-in-out;
}

/* Form group hover effect */
.form-group:hover {
    transform: translateX(5px);
}

/* Custom focus ring */
input:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Button hover animation */
button:hover, a:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Card hover effect */
.rounded-2xl:hover {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}
</style>
@endsection 