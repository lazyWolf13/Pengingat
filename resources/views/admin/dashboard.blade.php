@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-r from-green-200 via-green-300 to-green-400 flex flex-col justify-center">
    <h1 class="text-5xl font-extrabold text-white mb-16 tracking-wide text-center">Welcome, Admin!</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-4 sm:px-16">
        <!-- User Management Card -->
        <div class="flex justify-center">
            <div class="bg-white shadow-lg rounded-3xl p-8 w-full max-w-sm h-full">
                <div class="flex items-center space-x-6">
                    <svg class="text-green-600 w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m16-10a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h2 class="text-2xl font-semibold text-gray-800">User Management</h2>
                </div>
                <p class="text-gray-700 mt-4 mb-6">
                    Manage users and view their activity reports. Stay organized and efficient in monitoring your users.
                </p>
                <button class="w-full bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition-all duration-300">
                    Go to Users
                </button>
            </div>
        </div>

        <!-- Analytics Card -->
        <div class="flex justify-center">
            <div class="bg-white shadow-lg rounded-3xl p-8 w-full max-w-sm h-full">
                <div class="flex items-center space-x-6">
                    <svg class="text-green-500 w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v5m0-5a9 9 0 00-9-9h5m9 9v5m0-5a9 9 0 009-9h-5" />
                    </svg>
                    <h2 class="text-2xl font-semibold text-gray-800">Analytics</h2>
                </div>
                <p class="text-gray-700 mt-4 mb-6">
                    View performance metrics, track key metrics, and gain insights to improve your business decisions.
                </p>
                <button class="w-full bg-green-500 text-white py-3 px-6 rounded-lg hover:bg-green-600 transition-all duration-300">
                    View Analytics
                </button>
            </div>
        </div>

        <!-- Settings Card -->
        <div class="flex justify-center">
            <div class="bg-white shadow-lg rounded-3xl p-8 w-full max-w-sm h-full">
                <div class="flex items-center space-x-6">
                    <svg class="text-green-700 w-16 h-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 00-4 0m8 0a4 4 0 00-4 0M5.5 7.5l.5-1.5m12.5 0l-.5-1.5M12 11.646a4 4 0 00-4 0m8 0a4 4 0 00-4 0" />
                    </svg>
                    <h2 class="text-2xl font-semibold text-gray-800">Settings</h2>
                </div>
                <p class="text-gray-700 mt-4 mb-6">
                    Customize and configure the app settings to suit your needs, ensuring smooth operation and security.
                </p>
                <button class="w-full bg-green-700 text-white py-3 px-6 rounded-lg hover:bg-green-800 transition-all duration-300">
                    Open Settings
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
