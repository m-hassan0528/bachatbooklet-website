<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Blog Category
        </h2>
    </x-slot>

   <div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('blog-categories.index') }}"
               class="inline-flex items-center gap-2 text-sm text-gray-500 bg-gray-100 hover:bg-gray-200 px-3 py-2 rounded-lg transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Back
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Edit Blog Category</h2>
                <p class="text-sm text-gray-500 mt-0.5">Update category details</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-8">
            <form action="{{ route('blog-categories.update', $blogCategory->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5" for="name">
                      Blog   Category Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name', $blogCategory->name) }}"
                           placeholder="e.g. Mobile Accessories"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:border-gray-800 focus:ring-2 focus:ring-gray-800/10 transition @error('name') border-red-400 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Current Slug --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Current Slug</label>
                    <input type="text" value="{{ $blogCategory->slug }}" readonly
                           class="w-full border border-gray-100 bg-gray-50 rounded-lg px-4 py-2.5 text-sm text-gray-400 cursor-not-allowed">
                    <p class="text-xs text-gray-400 mt-1">Slug updates automatically when you change the name.</p>
                </div>

                {{-- Image --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5" for="image">
                        Category Image <span class="text-gray-400 font-normal">(optional)</span>
                    </label>
                    @if($blogCategory->image)
                        <img src="{{ $blogCategory->image_url }}" alt="{{ $blogCategory->name }}"
                             class="w-32 h-20 object-cover rounded-lg mb-2">
                        <p class="text-xs text-gray-400 mb-2">Upload a new image to replace the current one.</p>
                    @endif
                    <input type="file" name="image" id="image"
                           accept="image/jpeg,image/png,image/jpg,image/webp"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-600 file:mr-4 file:py-1.5 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-800 file:text-white hover:file:bg-red-600 transition">
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('blog-categories.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-gray-800 hover:bg-red-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Update Category
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

</x-app-layout>