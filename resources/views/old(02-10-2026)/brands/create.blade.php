<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Brand') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if ($errors->has('error'))
                <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ $errors->first('error') }}
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('brands.partials.brand-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
