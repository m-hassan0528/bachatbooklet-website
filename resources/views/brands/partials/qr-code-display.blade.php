<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('QR Code Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('This QR code directs users to the brand\'s voucher listing page.') }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        <div>
            <x-input-label for="qr_code" :value="__('QR Code')" />
            <x-text-input id="qr_code" type="text" class="mt-1 block w-full bg-gray-100" :value="$brand->qr_code" readonly />
            <p class="mt-2 text-sm text-gray-600">{{ __('This code was automatically generated and cannot be changed.') }}</p>
        </div>

        @if($brand->qr_code_image)
            <div>
                <x-input-label :value="__('QR Code Image')" />
                <div class="mt-2 p-4 bg-gray-50 rounded-lg inline-block">
                    <img src="{{ asset('storage/' . $brand->qr_code_image) }}" alt="QR Code for {{ $brand->name }}" class="h-48 w-48">
                </div>
                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Scans to: ') }}
                    <a href="{{ route('brands.vouchers', ['qr_code' => $brand->qr_code]) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                        {{ route('brands.vouchers', ['qr_code' => $brand->qr_code]) }}
                    </a>
                </p>
            </div>
        @endif
    </div>
</section>
