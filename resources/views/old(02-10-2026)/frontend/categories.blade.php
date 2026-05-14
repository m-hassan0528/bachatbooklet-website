@extends('layouts.user.app')

@section('content')

<!-- Page Banner -->
<section class="category-banner relative  bg-gray-900">
    <img src="{{ asset('images/category-banner.jpg') }}"
         class="absolute inset-0 w-full h-full object-cover opacity-60"
         alt="Categories">
    <div class="relative z-10 flex items-center justify-center h-full">
        <h1 class="text-4xl font-bold text-white">All Categories</h1>
    </div>
</section>

<!-- Categories Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

        @foreach($categories as $key => $label)
        <a href="{{ route('category.brands', $key) }}"
           class="group relative rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition">

            <!-- Category Image -->
            <img src="{{ asset('images/categories/'.$key.'.jpg') }}"
                 class="w-full h-48 object-cover group-hover:scale-105 transition duration-300"
                 alt="{{ $label }}">

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                <h3 class="text-white text-xl font-bold text-center">
                    {{ $label }}
                </h3>
            </div>

        </a>
        @endforeach

    </div>
</section>

@endsection
