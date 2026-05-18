<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($blog) ? __('Edit Blogs') : __('Create Blogs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex items-center gap-4 mb-6">
                <a href="{{ route('admin-blogs.index') }}"
                   class="inline-flex items-center gap-2 text-sm text-gray-500 bg-gray-100 hover:bg-gray-200 px-3 py-2 rounded-lg transition">
                    Back
                </a>

                <div>
                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ isset($blog) ? 'Edit Blog' : 'Create New Blog' }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-0.5">
                        Fill in the details to publish a blog post
                    </p>
                </div>
            </div>

            {{-- Form --}}
            <div class="bg-white rounded-xl shadow-sm p-8">

                <form id="blogForm"
                      action="{{ isset($blog) ? route('admin-blogs.update', $blog->id) : route('admin-blogs.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    @if(isset($blog))
                        @method('PUT')
                    @endif

                    {{-- TITLE --}}
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Blog Title
                        </label>

                        <input type="text"
                               name="title"
                               value="{{ old('title', $blog->title ?? '') }}"
                               class="w-full border rounded-lg px-4 py-2.5 text-sm"
                               placeholder="Enter blog title">
                    </div>
                    {{-- Category -- ADD THIS BLOCK after the title field --}}
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5" for="blog_category_id">
                            Category <span class="text-gray-400 font-normal">(optional)</span>
                        </label>
                        <select id="blog_category_id" name="blog_category_id"
                                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:border-gray-800 focus:ring-2 focus:ring-gray-800/10 transition @error('blog_category_id') border-red-400 @enderror">
                            <option value="">— No Category —</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('blog_category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('blog_category_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- IMAGE --}}
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Featured Image
                        </label>

                        <input type="file"
                               name="image"
                               class="w-full border rounded-lg px-4 py-2.5 text-sm">
                    </div>

                    {{-- QUILL EDITOR --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Content
                        </label>

                        <!-- Quill Editor -->
                        <div id="editor" style="height: 350px; background: white;">
                            {!! old('content', $blog->content ?? '') !!}
                        </div>

                        <!-- Hidden input for Laravel -->
                        <input type="hidden" name="content" id="content">
                    </div>

                    {{-- BUTTONS --}}
                    <div class="flex justify-end gap-3 pt-4 border-t">

                        <a href="{{ route('admin-blogs.index') }}"
                           class="px-5 py-2.5 bg-gray-100 rounded-lg text-sm">
                            Cancel
                        </a>

                        <button type="submit"
                                class="px-5 py-2.5 bg-gray-800 text-white rounded-lg text-sm hover:bg-black">
                            {{ isset($blog) ? 'Update Blog' : 'Publish Blog' }}
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    {{-- QUILL CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    {{-- QUILL JS --}}
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

    <script>
        // Init Quill
        const quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Write your blog content...',
            modules: {
                toolbar: [
                    [{ header: [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });

        // Form submit handler
        const form = document.getElementById('blogForm');
        const contentInput = document.getElementById('content');

        form.addEventListener('submit', function () {
            contentInput.value = quill.root.innerHTML;
        });
    </script>

</x-app-layout>