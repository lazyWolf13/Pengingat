@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gray-100 flex p-8">
    <div class="flex-1">
        <h1 class="text-5xl font-extrabold text-gray-800 mb-12 tracking-wide text-center">Business Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <!-- Total Customers Card -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700">Customers</h3>
                <p class="text-3xl font-bold text-blue-600">54,235</p>
            </div>
            <!-- Total Income Card -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700">Income</h3>
                <p class="text-3xl font-bold text-blue-600">$980,632</p>
            </div>
            <!-- Products Sold Card -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700">Products Sold</h3>
                <p class="text-3xl font-bold text-blue-600">5,490</p>
            </div>
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mb-4">Marketplace</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
            <!-- Data Analytics Card -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700">Data Analytics Overview</h3>
                <p class="text-gray-600">See how your account grow and how you can boost it.</p>
                <button class="mt-4 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-all duration-300">Start</button>
            </div>
            <!-- Finance Flow Card -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700">Finance Flow</h3>
                <p class="text-gray-600">$2,530</p>
                <p class="text-gray-500">September 2021</p>
            </div>
            <!-- Upgrade Card -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700">Upgrade to Pro</h3>
                <p class="text-gray-600">$29 p/m</p>
                <p class="text-gray-500">100% insurance for your goods</p>
                <button class="mt-4 bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-all duration-300">Upgrade</button>
            </div>
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mb-4">Recent Orders</h2>
        <table class="min-w-full bg-white shadow-lg rounded-lg">
            <thead>
                <tr class="bg-gray-200 text-gray-600">
                    <th class="py-2 px-4">Order ID</th>
                    <th class="py-2 px-4">Product</th>
                    <th class="py-2 px-4">Date</th>
                    <th class="py-2 px-4">Amount</th>
                    <th class="py-2 px-4">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="py-2 px-4">#123546</td>
                    <td class="py-2 px-4">DJI Mavic Pro 2</td>
                    <td class="py-2 px-4">Sep 16, 2021</td>
                    <td class="py-2 px-4">$42.00</td>
                    <td class="py-2 px-4 text-green-600">Delivered</td>
                </tr>
                <tr>
                    <td class="py-2 px-4">#1235468</td>
                    <td class="py-2 px-4">iPad Pro 2017 Model</td>
                    <td class="py-2 px-4">Sep 15, 2021</td>
                    <td class="py-2 px-4">$932.00</td>
                    <td class="py-2 px-4 text-red-600">Canceled</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="w-1/3 ml-8">
        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Summary</h2>
            <p class="text-lg font-semibold">Your Balance</p>
            <p class="text-2xl font-bold text-blue-600">$10,632.00</p>
            <p class="text-gray-500">+$3,250.07</p>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Activity</h2>
            <p class="text-gray-700">Withdraw Earnings: $4,120</p>
            <p class="text-gray-700">Paying Website Tax: -$230</p>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Top Categories</h2>
            <p class="text-gray-700">Footwear: 18,941 units</p>
            <p class="text-gray-700">Accessories: 26,061 units</p>
        </div>
    </div>
</div>

<!-- Logout Button -->
<div class="absolute bottom-6 right-6">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="flex items-center px-5 py-2 bg-red-600 text-white text-sm font-semibold rounded-full shadow-lg hover:bg-red-700 transition-all duration-300">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H4a3 3 0 01-3-3V7a3 3 0 013-3h6a3 3 0 013 3v1" />
            </svg>
            Logout
        </button>
    </form>
</div>
@endsection