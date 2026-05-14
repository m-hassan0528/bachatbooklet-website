@extends('layouts.user.app')

@section('content')
<section class="py-20 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4">

        <div class="bg-white rounded-2xl shadow p-8 text-center">

            @if($brand->logo)
                <img src="{{ asset('storage/'.$brand->logo) }}"
                     alt="{{ $brand->name }}"
                     class="mx-auto h-32 object-contain mb-6">
            @endif

            <h1 class="text-3xl font-extrabold text-gray-900">
                {{ $brand->name }}
            </h1>

            <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                {{ $brand->description ?? 'Exclusive offers available for this brand.' }}
            </p>

            <div class="mt-6 inline-flex items-center px-6 py-3 rounded-full bg-primary text-white text-sm font-semibold">
                Category:
                <span class="ml-2 capitalize">
                    {{ str_replace('_',' ', $brand->category) }}
                </span>
            </div>

            {{-- Future: offers, vouchers, discounts --}}
        </div>

    </div>
</section>
@endsection
