<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Brand') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
              @if (session('status'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-700">
                    {{ session('status') }}
                </div>
            @endif
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('brands.partials.brand-form', ['brand' => $brand])
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('brands.partials.qr-code-display', ['brand' => $brand])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
