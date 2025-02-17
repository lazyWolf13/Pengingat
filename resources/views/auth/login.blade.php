<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Forest Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-200 via-teal-300 to-green-400 min-h-screen flex items-center justify-center px-4">
    <div class="bg-white shadow-2xl rounded-3xl w-full max-w-md p-8">
        <!-- Logo SVG -->
        <div class="flex justify-center mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-16 h-16 text-teal-600">
                <path fill="currentColor" d="M411.1,155.87a5.52,5.52,0,0,0-4.74-1.58c-.28,0-28.32,4.35-90.78,7.55L314,162c-81-90-209.5-52.19-210.79-51.78a5.44,5.44,0,0,0-.58,10.19c30,13,66.77,70.06,76.45,85.73-15.67,11.52-29,25.46-38.23,42.3-20.84,38.14-21.11,77.28-2.55,98.33-17.77,32.23-19.44,55.46-19.55,57.61a5.44,5.44,0,0,0,5.13,5.71h.3a5.45,5.45,0,0,0,5.43-5.14c0-.48,1.64-21,17.56-50.52.85.56,1.64,1.17,2.54,1.67a4.56,4.56,0,0,0,.67.32c1.86.73,28.67,11,63.77,11,24.2,0,52.33-4.86,78.93-21.06,67-40.78,111.54-142.67,119.47-185.65A5.48,5.48,0,0,0,411.1,155.87Z" />
            </svg>
        </div>

        <h2 class="text-3xl font-bold text-center text-teal-700 mb-6">Login Forest Portal</h2>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-700 font-semibold">Email:</label>
                <input type="email" name="email" required 
                    class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 shadow-sm">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-gray-700 font-semibold">Password:</label>
                <input type="password" name="password" required 
                    class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 shadow-sm">
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
</body>
</html>
