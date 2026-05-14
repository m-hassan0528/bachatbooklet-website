<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $brand->name }} - Redeem Voucher</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <!-- Brand Logo/Image Placeholder -->
            <div class="text-center mb-6">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full mx-auto flex items-center justify-center text-white text-2xl font-bold">
                    {{ substr($brand->name, 0, 1) }}
                </div>
            </div>

            <!-- Brand Name -->
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">
                {{ $brand->name }}
            </h2>

            <!-- Brand Category -->
            @if($brand->category)
                <p class="text-center text-sm text-gray-500 mb-4">
                    {{ ucfirst($brand->category) }}
                </p>
            @endif

            <!-- Brand Description -->
            @if($brand->description)
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-600 text-sm">{{ $brand->description }}</p>
                </div>
            @endif

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-green-800 text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <ul class="text-red-800 text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Redemption Form -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Redeem Your Voucher</h3>

                <form method="POST" action="{{ route('brands.vouchers.redeem', $brand->qr_code) }}">
                    @csrf

                    <div class="mb-4">
                        <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                            Enter Universal Code
                        </label>
                        <input
                            type="text"
                            id="code"
                            name="code"
                            value="{{ old('code') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent uppercase"
                            placeholder="Enter your code"
                            required
                            autocomplete="off"
                        >
                        <p class="mt-2 text-xs text-gray-500">
                            Please enter your universal redemption code
                        </p>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 ease-in-out transform hover:scale-105"
                    >
                        Redeem Voucher
                    </button>
                </form>
            </div>

            <!-- Additional Info -->
            <div class="text-center text-xs text-gray-500 mt-6">
                <p>Make sure you have a valid universal code to redeem your voucher.</p>
            </div>
        </div>
    </div>
</body>
</html>
