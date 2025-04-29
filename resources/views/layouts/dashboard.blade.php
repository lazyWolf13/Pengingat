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

        .nav-button {
            background-color: white;
            color: #1e40af;
        }

        .nav-button:hover {
            background-color: #3b82f6;
            color: white;
        }

        .nav-button.active {
            background-color: #3b82f6;
            color: white;
        }

        .dashboard-button {
            background-color: #3b82f6;
            color: white;
        }

        .dashboard-button:hover {
            background-color: #2563eb;
            color: white;
        }

        /* Custom styles for the buttons */
        #menu-toggle {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 20;
        }

        #arrow-toggle {
            position: absolute;
            top: 10px;
            left: 64px; /* Adjust this value to place the arrow next to sidebar */
            z-index: 20;
            display: none;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-100 via-blue-200 to-blue-300 min-h-screen">

    <!-- Container utama -->
    <div class="flex">
        <!-- Sidebar dengan scroll -->
        <aside id="sidebar" class="w-64 bg-gradient-to-t from-blue-300 to-blue-200 text-gray-900 p-6 fixed top-0 left-0 h-screen shadow-lg overflow-y-auto transition-transform duration-300 ease-in-out lg:translate-x-0 -translate-x-full lg:block">
            <h2 class="text-3xl font-extrabold tracking-wide mb-6 text-blue-800">Dashboard</h2>

            <!-- Tombol Dashboard -->
            <a href="dashboard" class="dashboard-button block py-3 px-4 text-lg font-semibold rounded-lg shadow-md text-center mb-6">🏠 Dashboard</a>

            <nav class="space-y-4">
                <!-- Menu User & Admin -->
                <h3 class="text-gray-600 uppercase text-xs font-bold">User Management</h3>
                <a href="/admin/adminuser" class="nav-button block py-2 px-4 rounded-lg">👤 Kelola Admin</a>
                <a href="/admin/user" class="nav-button block py-2 px-4 rounded-lg">👥 Kelola Pengguna</a>

                <!-- Menu Absensi -->
                <h3 class="text-gray-600 uppercase text-xs font-bold">Absensi</h3>
                <a href="/admin/attendance" class="nav-button block py-2 px-4 rounded-lg">📆 Data Absensi</a>
                <a href="/admin/leavereq" class="nav-button block py-2 px-4 rounded-lg">📂 Permintaan Cuti</a>

                <!-- Menu Profil -->
                <h3 class="text-gray-600 uppercase text-xs font-bold">Profil</h3>
                <a href="/admin/profiles" class="nav-button block py-2 px-4 rounded-lg">🏢 Informasi Profil</a>
                <a href="/admin/foto" class="nav-button block py-2 px-4 rounded-lg">📸 Foto Sampul</a>
                <a href="/admin/kategori" class="nav-button block py-2 px-4 rounded-lg">🏷️ Kategori</a>
                <a href="/admin/posts" class="nav-button block py-2 px-4 rounded-lg">📝 Posts</a>
                <a href="/admin/gallery" class="nav-button block py-2 px-4 rounded-lg">🖼️ Gallery</a>
                <a href="/admin/image" class="nav-button block py-2 px-4 rounded-lg">📸 Foto</a>
                <div class="pt-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full py-2 px-4 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200">🚪
                            Logout</button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Konten Utama -->
        <main class="ml-0 lg:ml-64 p-10 w-full space-y-12">
            @yield('content')
            <!-- Tempat untuk konten dinamis -->
        </main>
    </div>

    <!-- Hamburger and Arrow Button -->
    <div class="lg:hidden p-4 flex justify-between items-center">
        <!-- Hamburger Button -->
        <button id="menu-toggle" class="text-2xl text-blue-800">
            ☰
        </button>
    </div>

    <!-- Arrow Button (to hide sidebar) -->
    <button id="arrow-toggle" class="text-2xl text-blue-800">
        &#8592;
    </button>

    <script>
        // Toggle Sidebar for mobile
        const sidebar = document.getElementById('sidebar');
        const menuToggle = document.getElementById('menu-toggle');
        const arrowToggle = document.getElementById('arrow-toggle');

        menuToggle.addEventListener('click', function() {
            // Toggle sidebar visibility
            sidebar.classList.toggle('-translate-x-full');
            // Hide hamburger and show arrow button
            menuToggle.classList.toggle('hidden');
            arrowToggle.classList.toggle('hidden');
        });

        arrowToggle.addEventListener('click', function() {
            // Hide sidebar and show hamburger button again
            sidebar.classList.add('-translate-x-full');
            // Hide arrow button and show hamburger button
            arrowToggle.classList.add('hidden');
            menuToggle.classList.remove('hidden');
        });

        document.addEventListener('DOMContentLoaded', function() {
            const navButtons = document.querySelectorAll('.nav-button');
            
            navButtons.forEach(button => {
                button.addEventListener('click', function() {
                    navButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            const currentPath = window.location.pathname;
            navButtons.forEach(button => {
                if (button.getAttribute('href') === currentPath) {
                    button.classList.add('active');
                }
            });
        });
    </script>

</body>

</html>
