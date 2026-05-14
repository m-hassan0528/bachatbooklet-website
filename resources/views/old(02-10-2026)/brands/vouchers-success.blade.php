<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Voucher Redeemed - {{ $brand->name }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-green-50 to-blue-50">

        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-md overflow-hidden sm:rounded-lg">

            <!-- Success Icon -->
            <div class="text-center mb-6">
                <div class="w-20 h-20 bg-green-500 rounded-full mx-auto flex items-center justify-center">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <!-- Success Message -->
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">
                Voucher Redeemed Successfully!
            </h2>

            <p class="text-center text-gray-600 mb-6">
                Your voucher for <span class="font-semibold">{{ $brand->name }}</span> has been successfully redeemed.
            </p>

            <!-- Redemption Details -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Redemption Details</h3>

                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Brand:</span>
                        <span class="font-medium text-gray-900">{{ $brand->name }}</span>
                    </div>

                    @if($brand->category)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Category:</span>
                        <span class="font-medium text-gray-900">{{ ucfirst($brand->category) }}</span>
                    </div>
                    @endif

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Redeemed At:</span>
                        <span class="font-medium text-gray-900">{{ now()->format('M d, Y h:i A') }}</span>
                    </div>

                    @if($redemption_id)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Redemption ID:</span>
                        <span class="font-medium text-gray-900">#{{ $redemption_id }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Instructions -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-800">
                            Please show this confirmation screen to the staff at {{ $brand->name }} to claim your voucher.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Thank You Message -->
            <div class="text-center mb-6">
                <p class="text-gray-600 text-sm">
                    Thank you for choosing {{ $brand->name }}!
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="{{ route('brands.vouchers', $brand->qr_code) }}"
                   class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                    Redeem Another Voucher
                </a>

                <a href="/"
                   class="block w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-4 rounded-lg transition duration-200">
                    Back to Home
                </a>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="mt-6 text-center text-xs text-gray-500">
            <p>Keep this screen until you receive your voucher benefit</p>
        </div>
    </div>
</body>
</html>
