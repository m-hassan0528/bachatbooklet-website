@extends('layouts.user.app')

@section('content')
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">

        <div class="text-center mb-12">
           <h1 class="text-4xl font-extrabold text-gray-900 capitalize">
    {{ ucfirst(str_replace('_', ' & ', $brands->first()->category)) }}
</h1>
            <p class="mt-3 text-gray-600">
                Explore all brands in this category
            </p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-8">

            @foreach($brands as $brand)
                <a href="{{ route('brand.show', $brand->slug) }}"
                   class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition p-6 flex flex-col items-center text-center">

                    <div class="h-24 w-full flex items-center justify-center mb-4">
                        @if($brand->logo)
                            <img src="{{ asset('storage/'.$brand->logo) }}"
                                 class="object-contain h-full group-hover:scale-105 transition">
                        @else
                            <span class="text-gray-400 text-sm">No Logo</span>
                        @endif
                    </div>

                    <h4 class="text-sm font-semibold text-gray-900">
                        {{ $brand->name }}
                    </h4>
                </a>
            @endforeach

        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $brands->links() }}
        </div>

    </div>
</section>
@endsection
