<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Forest Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-custom {
            background-image: url('{{ asset('storage/kehutanan.jpg') }}');
            background-size: cover;
            background-position: center;
        }
    </style>
    <script>
        function showLoading(button) {
            button.innerHTML = 'Loading...'; // Mengubah teks tombol
            button.disabled = true; // Menonaktifkan tombol
            button.classList.add('opacity-50'); // Menambahkan efek transparansi
        }
    </script>
</head>
<body class="bg-custom min-h-screen flex items-center justify-center px-4">
    <div class="bg-white bg-opacity-80 shadow-2xl rounded-3xl w-full max-w-2xl p-10 flex items-center">
        <!-- Logo Image -->
        <div class="flex-shrink-0 mr-6 w-1/3">
            <img src="{{ asset('storage/logo-kehutanan.png') }}" alt="Logo Kehutanan" class="w-full h-auto">
        </div>
        <!-- Form Container -->
        <div class="flex-grow">
            <h2 class="text-3xl font-bold text-center text-teal-700 mb-6">Login Forest Portal</h2>
            <form action="{{ route('login') }}" method="POST" class="space-y-6" onsubmit="showLoading(this.querySelector('button[type=submit]'))">
                @csrf
                <!-- Email -->
                <div>
                    <label for="email" class="block text-gray-700 font-semibold">Email:</label>
                    <input type="email" name="email" required 
                        class="w-full px-4 py-3 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 shadow-sm transition duration-200 ease-in-out">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-gray-700 font-semibold">Password:</label>
                    <input type="password" name="password" required 
                        class="w-full px-4 py-3 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 shadow-sm transition duration-200 ease-in-out">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}
                            class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Remember Me
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 transition-all duration-300 shadow-lg">
                    Login
                </button>
            </form>
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mt-4 bg-red-100 text-red-700 p-4 rounded-lg border border-red-300">
                    <ul class="list-disc pl-6">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
