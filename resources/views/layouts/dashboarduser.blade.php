
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hover-zoom:hover {
            transform: scale(1.03);
            transition: transform 0.3s ease;
        }
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-green-100 via-green-200 to-green-300 min-h-screen">
    <!-- Container utama -->
    <div class="flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-gradient-to-t from-green-300 to-green-200 text-gray-900 p-6 fixed top-0 left-0 h-screen shadow-lg overflow-y-auto transition-transform transform">
            <!-- Tombol close -->
            <button id="closeSidebar" class="absolute top-4 right-4 text-gray-700 hover:text-red-500 text-2xl">&times;</button>
            <!-- User Profile Section -->
            <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-green-400">
                <div class="h-12 w-12 rounded-full bg-white flex items-center justify-center">
                    <span class="text-xl font-bold text-green-600">{{ auth()->check() ? strtoupper(substr(auth()->user()->full_name, 0, 1)) : 'U' }}</span>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-gray-900">{{ auth()->check() ? auth()->user()->full_name : 'User' }}</h2>
                    <p class="text-xs text-gray-600">{{ auth()->check() ? auth()->user()->subdit : 'Subdit' }}</p>
                </div>
            </div>
            
            <!-- Menu Navigation -->
            <nav class="space-y-4">
                <a href="{{ route('user.dashboard') }}" class="block py-3 px-4 bg-green-600 text-white text-lg font-semibold rounded-lg hover:bg-green-700 shadow-md text-center mb-6">
                    🏠 Dashboard
                </a>
                <h3 class="text-gray-600 uppercase text-xs font-bold">Absensi</h3>
                <a href="{{ route('user.attendance') }}" class="block py-2 px-4 text-green-700 rounded-lg hover:bg-green-300">📍 Absen Harian</a>
                <a href="{{ route('user.attendance_history') }}" class="block py-2 px-4 text-green-700 rounded-lg hover:bg-green-300">📅 Riwayat Absensi</a>
                <h3 class="text-gray-600 uppercase text-xs font-bold">Tugas</h3>
                <a href="my_tasks" class="block py-2 px-4 text-green-700 rounded-lg hover:bg-green-300">✅ Tugas Saya</a>
                <a href="task_progress" class="block py-2 px-4 text-green-700 rounded-lg hover:bg-green-300">📊 Progress</a>
                <h3 class="text-gray-600 uppercase text-xs font-bold">Dokumen</h3>
                <a href="documents" class="block py-2 px-4 text-green-700 rounded-lg hover:bg-green-300">📁 Dokumen Saya</a>
                <a href="shared_documents" class="block py-2 px-4 text-green-700 rounded-lg hover:bg-green-300">🔄 Dokumen Bersama</a>
                <h3 class="text-gray-600 uppercase text-xs font-bold">Pengaturan</h3>
                <a href="profile" class="block py-2 px-4 text-green-700 rounded-lg hover:bg-green-300">👤 Profil Saya</a>
                <a href="notifications" class="block py-2 px-4 text-green-700 rounded-lg hover:bg-green-300">🔔 Notifikasi</a>
                <div class="pt-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full py-2 px-4 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200">🚪 Logout</button>
                    </form>
                </div>
            </nav>
        </aside>
        <!-- Konten Utama -->
        <main id="main-content" class="ml-64 p-10 w-full space-y-12 transition-all duration-300">
            <!-- Header Section -->
            <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-md">
                <div class="flex items-center space-x-4">
                    <!-- Tombol Hamburger untuk membuka sidebar -->
                    <button id="openSidebar" class="p-2 hover:bg-gray-200 rounded-lg">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">@yield('title', 'Dashboard')</h1>
                        <p class="text-sm text-gray-500">{{ \Carbon\Carbon::now()->format('l, d F Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="p-2 hover:bg-gray-100 rounded-full relative">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full text-xs text-white flex items-center justify-center">3</span>
                    </button>
                </div>
            </div>
            <!-- Content Section -->
            @yield('content')
        </main>
    </div>
    <script>
        const sidebar = document.getElementById("sidebar");
        const mainContent = document.getElementById("main-content");
        const openSidebar = document.getElementById("openSidebar");
        const closeSidebar = document.getElementById("closeSidebar");
        openSidebar.addEventListener("click", () => {
            sidebar.classList.remove("-translate-x-full");
            mainContent.classList.add("ml-64");
        });
        closeSidebar.addEventListener("click", () => {
            sidebar.classList.add("-translate-x-full");
            mainContent.classList.remove("ml-64");
        });
    </script>
</body>
</html>
