<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
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

<body class="bg-gradient-to-br from-blue-100 via-blue-200 to-blue-300 min-h-screen">

    <!-- Container utama -->
    <div class="flex">
        <!-- Sidebar dengan scroll -->
        <aside
            class="w-64 bg-gradient-to-t from-blue-300 to-blue-200 text-gray-900 p-6 fixed top-0 left-0 h-screen shadow-lg overflow-y-auto">
            <h2 class="text-3xl font-extrabold tracking-wide mb-6 text-blue-800">Dashboard</h2>

            <!-- Tombol Dashboard -->
            <a href="dashboard"
                class="block py-3 px-4 bg-blue-500 text-white text-lg font-semibold rounded-lg hover:bg-blue-600 shadow-md text-center mb-6">🏠
                Dashboard</a>

            <nav class="space-y-4">
                <!-- Menu User & Admin -->
                <h3 class="text-gray-600 uppercase text-xs font-bold">User Management</h3>
                <a href="/admin/adminuser"
                    class="block py-2 px-4 bg-blue-500 text-white rounded-lg hover:bg-blue-600">👤 Kelola Admin</a>
                <a href="/admin/user" class="block py-2 px-4 bg-blue-400 text-white rounded-lg hover:bg-blue-500">👥
                    Kelola Pengguna</a>

                <!-- Menu Absensi -->
                <h3 class="text-gray-600 uppercase text-xs font-bold">Absensi</h3>
                <a href="attendance_records"
                    class="block py-2 px-4 bg-blue-400 text-white rounded-lg hover:bg-blue-500">📆 Data Absensi</a>
                <a href="/admin/summaries"
                    class="block py-2 px-4 bg-blue-400 text-white rounded-lg hover:bg-blue-500">📊 Rekap Absensi</a>

                <!-- Menu Tugas & Pekerjaan -->
                <h3 class="text-gray-600 uppercase text-xs font-bold">Manajemen Tugas</h3>
                <a href="/admin/rekap-pengingat"
                    class="block py-2 px-4 bg-blue-400 text-white rounded-lg hover:bg-blue-500">✅ Daftar Tugas</a>
                <a href="task_assignments"
                    class="block py-2 px-4 bg-blue-400 text-white rounded-lg hover:bg-blue-500">📋 Penugasan</a>
                <a href="task_history" class="block py-2 px-4 bg-blue-400 text-white rounded-lg hover:bg-blue-500">⏳
                    Riwayat Tugas</a>

                <!-- Menu Lainnya -->
                <h3 class="text-gray-600 uppercase text-xs font-bold">Sistem</h3>
                <a href="cache" class="block py-2 px-4 bg-blue-400 text-white rounded-lg hover:bg-blue-500">⚙️ Cache</a>
                <a href="jobs" class="block py-2 px-4 bg-blue-400 text-white rounded-lg hover:bg-blue-500">🔄 Pekerjaan
                    Background</a>
                <a href="logins" class="block py-2 px-4 bg-blue-400 text-white rounded-lg hover:bg-blue-500">🔐 Log
                    Masuk</a>
                <a href="reminders" class="block py-2 px-4 bg-blue-400 text-white rounded-lg hover:bg-blue-500">⏰
                    Pengingat</a>
                <a href="/admin/leavereq" class="block py-2 px-4 bg-blue-400 text-white rounded-lg hover:bg-blue-500">📂
                    Lave Request</a>

                <!-- Menu Profil -->
                <h3 class="text-gray-600 uppercase text-xs font-bold">Profil</h3>
                <a href="/admin/profiles" class="block py-2 px-4 bg-blue-400 text-white rounded-lg hover:bg-blue-500">🏢
                    Informasi Profil</a>
                <a href="/admin/foto" class="block py-2 px-4 bg-blue-400 text-white rounded-lg hover:bg-blue-500">📸
                    Galeri Foto</a>
            </nav>
        </aside>

        <!-- Konten Utama -->
        <main class="ml-64 p-10 w-full space-y-12">
            @yield('content')
            <!-- Tempat untuk konten dinamis -->
        </main>
    </div>

</body>

</html>