@extends('layouts.user.app')
@section('content')

<!--    slider  -->
<div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="3000">

    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('slider/slider1.png') }}" class="d-block w-100 img-fluid" alt="Slider 1">
        </div>

        <div class="carousel-item">
            <img src="{{ asset('slider/slider2.jpg') }}" class="d-block w-100 img-fluid" alt="Slider 2">
        </div>
    </div>

    <a class="carousel-control-prev" href="#carouselExampleControls" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </a>

    <a class="carousel-control-next" href="#carouselExampleControls" data-slide="next">
        <span class="carousel-control-next-icon"></span>
    </a>
</div>

<!-- Hero Section -->
<section class="bg-gradient-to-br from-green-50 via-white to-yellow-50 py-20 md:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                Enjoy, Save, Love, <span class="text-primary">Repeat!</span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-600 mb-8 max-w-4xl mx-auto">
                Unlock the Magic of Your City: Explore Thousands of Buy One Get One Free Offers on Dining, Attractions,
                Beauty, Fitness, and Travel
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 mb-12">
                <a href="#categories"
                    class="btn-primary text-white px-10 py-4 rounded-full text-lg font-semibold inline-block">
                    Explore Offers
                </a>
                <a href="#how-it-works"
                    class="bg-white text-primary border-2 border-primary px-10 py-4 rounded-full text-lg font-semibold inline-block hover:bg-primary-lighter transition">
                    Learn More
                </a>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-16">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="text-3xl font-bold text-primary">1500+</div>
                    <div class="text-gray-600 mt-2">Offers</div>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="text-3xl font-bold text-primary">50+</div>
                    <div class="text-gray-600 mt-2">Partner Brands</div>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="text-3xl font-bold text-primary">2+</div>
                    <div class="text-gray-600 mt-2">Cities</div>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="text-3xl font-bold text-primary">3 lacs+</div>
                    <div class="text-gray-600 mt-2">Saved</div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Brands Section Start -->
<section id="brands" class="py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="text-center mb-16">
            <span class="text-sm font-semibold text-primary uppercase tracking-wider">
                Trusted Partners
            </span>
            <h2 class="mt-2 text-4xl font-extrabold text-gray-900">
                Our Partner Brands
            </h2>
            <p class="mt-4 max-w-2xl mx-auto text-gray-600">
                Unlock exclusive savings from top brands across multiple categories
            </p>
        </div>

        @php
        $categoryLabels = [
        'food_drink' => 'Food & Drink',
        'beauty_fitness' => 'Beauty & Fitness',
        'fashion_retail' => 'Fashion & Retail',
        'entertainment' => 'Entertainment',
        'travel_tourism' => 'Travel & Tourism',
        'services' => 'Services',
        'health_wellness' => 'Health & Wellness',
        'home_lifestyle' => 'Home & Lifestyle',
        ];
        @endphp

        @forelse($brands as $category => $categoryBrands)

        <!-- Category Block -->
        <div class="mb-16">

            <!-- Category Title -->
           <div class="flex items-center gap-4 mb-8">

    <!-- Category Title -->
   <h3 class="text-2xl font-bold text-gray-800 whitespace-nowrap">
    {{ ucfirst(str_replace('_', ' & ', $categoryBrands->first()->category)) }}
</h3>

   <!-- Divider Line -->
<span class="h-px flex-1 bg-gray-200"></span>

<!-- View More -->
@if(($categoryCounts[$category] ?? 0) > 5)

    <a href="{{ route('category.brands', str_replace('_', '-', $category)) }}"
       class="text-sm font-semibold text-primary hover:underline whitespace-nowrap">
        View More →
    </a>

@endif

</div>

            <!-- Brands Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-8">

                {{-- First 5 brands --}}
                @foreach($categoryBrands->take(5) as $brand)
                <a href="{{ route('brand.show', $brand->slug) }}"
                    class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 p-6 flex flex-col items-center text-center">

                    <div class="h-24 w-full flex items-center justify-center mb-4 rounded-xl">
                        @if($brand->logo)
                        <img src="{{ asset('storage/'.$brand->logo) }}" alt="{{ $brand->name }}"
                            class="category-logos object-contain transition-transform duration-300 group-hover:scale-105">
                        @else
                        <span class="text-gray-400 text-sm">No Logo</span>
                        @endif
                    </div>

                    <h4 class="text-sm font-semibold text-gray-900">
                        {{ $brand->name }}
                    </h4>

                    <span class="mt-3 text-xs font-medium text-primary opacity-0 group-hover:opacity-100 transition">
                        View Offers →
                    </span>
                </a>
                @endforeach
            </div>

        </div>

        @empty
        <p class="text-center text-gray-500">
            No brands available at the moment.
        </p>
        @endforelse

    </div>
</section>
<!-- Brands Section End -->

<!-- Order Book Section -->
<section id="order-book" class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Order Your BachatBooklet</h2>
            <p class="text-xl text-gray-600">Fill in your details and we'll deliver the book to your doorstep</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-gray-700 font-semibold mb-2">Full Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('name') border-red-500 @enderror">
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-gray-700 font-semibold mb-2">Phone Number *</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required pattern="03[0-9]{9}"
                    maxlength="11" placeholder="03001234567"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('phone') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Format: 03XXXXXXXXX (11 digits)</p>
                @error('phone')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Email -->
        <div class="mb-6">
            <label for="email" class="block text-gray-700 font-semibold mb-2">Email Address *</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('email') border-red-500 @enderror">
            @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Address -->
        <div class="mb-6">
            <label for="address" class="block text-gray-700 font-semibold mb-2">Full Address *</label>
            <textarea id="address" name="address" rows="3" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
            @error('address')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- City -->
            <div>
                <label for="city" class="block text-gray-700 font-semibold mb-2">City *</label>
                <input type="text" id="city" name="city" value="{{ old('city') }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('city') border-red-500 @enderror">
                @error('city')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- State -->
            <div>
                <label for="state" class="block text-gray-700 font-semibold mb-2">State *</label>
                <input type="text" id="state" name="state" value="{{ old('state') }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('state') border-red-500 @enderror">
                @error('state')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pincode -->
            <div>
                <label for="pincode" class="block text-gray-700 font-semibold mb-2">Pincode *</label>
                <input type="text" id="pincode" name="pincode" value="{{ old('pincode') }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('pincode') border-red-500 @enderror">
                @error('pincode')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Payment Method -->
        <div class="mb-8">
            <label class="block text-gray-700 font-semibold mb-3">Payment Method *</label>
            <div class="flex flex-col sm:flex-row gap-4">
                <label class="flex items-center cursor-pointer">
                    <input type="radio" name="payment_method" value="cod" checked
                        class="w-5 h-5 text-primary focus:ring-primary">
                    <span class="ml-3 text-gray-700">Cash on Delivery (COD)</span>
                </label>
                <label class="flex items-center cursor-pointer">
                    <input type="radio" name="payment_method" value="online"
                        class="w-5 h-5 text-primary focus:ring-primary">
                    <span class="ml-3 text-gray-700">Online Transfer (after order confirmation)</span>
                </label>
            </div>
            @error('payment_method')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit"
                class="bg-primary hover:bg-primary text-white px-12 py-4 rounded-full text-lg font-semibold transition-all transform hover:scale-105 shadow-lg">
                Place Order
            </button>
            <p class="text-sm text-gray-500 mt-4">We'll contact you within 24 hours to confirm your order</p>
        </div>
        </form>
    </div>
    </div>
</section>

<!-- CTA Section -->
<section class="gradient-gold py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Ready to Start Saving?</h2>
        <p class="text-xl text-gray-700 mb-8">Join thousands of smart savers and unlock exclusive deals today</p>
        <a href="#categories" class="btn-primary text-white px-12 py-4 rounded-full text-lg font-semibold inline-block">
            Get Started Now
        </a>
    </div>
</section>

@endsection