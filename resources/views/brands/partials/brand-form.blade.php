<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ isset($brand) ? __('Edit Brand Information') : __('Create New Brand') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ isset($brand) ? __("Update the brand's information.") : __("Add a new brand to the system. A unique QR code will be automatically generated.") }}
        </p>
    </header>

    <form method="post" action="{{ isset($brand) ? route('brands.update', $brand) : route('brands.store') }}"
        enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @if(isset($brand))
        @method('patch')
        @endif

        <div>
            <x-input-label for="name" :value="__('Brand Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                :value="old('name', $brand->name ?? '')" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <div>
            <x-input-label for="logo" :value="__('Brand Logo')" />

            <input id="logo" name="logo" type="file" accept="image/*"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

            <x-input-error class="mt-2" :messages="$errors->get('logo')" />

            @if(isset($brand) && $brand->logo)
            <div class="mt-3">
                <p class="text-sm text-gray-600 mb-1">Current Logo:</p>
                <img src="{{ asset('storage/' . $brand->logo) }}" alt="Brand Logo" class="h-16 rounded shadow">
            </div>
            @endif
        </div>

        <div>
            <x-input-label for="description" :value="__('Description')" />
            <textarea id="description" name="description" rows="4"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $brand->description ?? '') }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>

        <div>
            <x-input-label for="category" :value="__('Category')" />
           <select name="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    <option value="">Select a category</option>

    @foreach($categories as $value => $label)
        <option value="{{ $value }}"
            {{ old('category', $brand->category ?? '') == $value ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>
            <x-input-error class="mt-2" :messages="$errors->get('category')" />
        </div>

        <div class="flex items-center">
            <input id="is_active" name="is_active" type="checkbox" value="1"
                {{ old('is_active', $brand->is_active ?? true) ? 'checked' : '' }}
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
            <label for="is_active" class="ml-2 block text-sm text-gray-900">
                {{ __('Active') }}
            </label>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ isset($brand) ? __('Update') : __('Create') }}</x-primary-button>
            <a href="{{ route('brands.index') }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Cancel') }}
            </a>

            @if (session('status'))
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600">{{ session('status') }}</p>
            @endif
        </div>
    </form>
</section>