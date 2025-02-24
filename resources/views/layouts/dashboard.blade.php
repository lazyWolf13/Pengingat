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
    <aside class="w-64 bg-gradient-to-t from-blue-300 to-blue-200 text-gray-900 p-6 fixed top-0 left-0 h-screen shadow-lg overflow-y-auto">
      <h2 class="text-3xl font-extrabold tracking-wide mb-6 text-blue-800">Dashboard</h2>
      
      <!-- Tombol Dashboard -->
      <a href="dashboard" class="block py-3 px-4 bg-blue-600 text-white text-lg font-semibold rounded-lg hover:bg-blue-700 shadow-md text-center mb-6">🏠 Dashboard</a>
      
      <nav class="space-y-4">
        <!-- Menu User & Admin -->
        <h3 class="text-gray-600 uppercase text-xs font-bold">User Management</h3>
        <a href="{{ route('admin.index') }}" class="block py-2 px-4 bg-blue-500 text-white rounded-lg hover:bg-blue-600">👤 Kelola Admin</a>
        <a href="users" class="block py-2 px-4 text-blue-700 rounded-lg hover:bg-blue-300">👥 Kelola Pengguna</a>

        <!-- Menu Absensi -->
        <h3 class="text-gray-600 uppercase text-xs font-bold">Absensi</h3>
        <a href="attendance_records" class="block py-2 px-4 text-blue-700 rounded-lg hover:bg-blue-300">📆 Data Absensi</a>
        <a href="attendance_summaries" class="block py-2 px-4 text-blue-700 rounded-lg hover:bg-blue-300">📊 Rekap Absensi</a>

        <!-- Menu Tugas & Pekerjaan -->
        <h3 class="text-gray-600 uppercase text-xs font-bold">Manajemen Tugas</h3>
        <a href="tasks" class="block py-2 px-4 text-blue-700 rounded-lg hover:bg-blue-300">✅ Daftar Tugas</a>
        <a href="task_assignments" class="block py-2 px-4 text-blue-700 rounded-lg hover:bg-blue-300">📋 Penugasan</a>
        <a href="task_history" class="block py-2 px-4 text-blue-700 rounded-lg hover:bg-blue-300">⏳ Riwayat Tugas</a>

        <!-- Menu Lainnya -->
        <h3 class="text-gray-600 uppercase text-xs font-bold">Sistem</h3>
        <a href="cache" class="block py-2 px-4 text-blue-700 rounded-lg hover:bg-blue-300">⚙️ Cache</a>
        <a href="jobs" class="block py-2 px-4 text-blue-700 rounded-lg hover:bg-blue-300">🔄 Pekerjaan Background</a>
        <a href="logins" class="block py-2 px-4 text-blue-700 rounded-lg hover:bg-blue-300">🔐 Log Masuk</a>
        <a href="reminders" class="block py-2 px-4 text-blue-700 rounded-lg hover:bg-blue-300">⏰ Pengingat</a>
        <a href="sessions" class="block py-2 px-4 text-blue-700 rounded-lg hover:bg-blue-300">📂 Sesi Aktif</a>

        <!-- Menu Profil -->
        <h3 class="text-gray-600 uppercase text-xs font-bold">Profil</h3>
        <a href="profile" class="block py-2 px-4 text-blue-700 rounded-lg hover:bg-blue-300">🏢 Informasi Profil</a>
        <a href="foto" class="block py-2 px-4 text-blue-700 rounded-lg hover:bg-blue-300">📸 Galeri Foto</a>
      </nav>
    </aside>

    <!-- Konten Utama -->
    <main class="ml-64 p-10 w-full space-y-12">
      @yield('content')  <!-- Tempat untuk konten dinamis -->
    </main>
  </div>

</body>
</html>
