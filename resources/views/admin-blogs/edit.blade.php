<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Blog
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Form Card --}}
            <div class="bg-white rounded-xl shadow-sm p-8">

                <form id="blogForm"
                      action="{{ route('admin-blogs.update', $blog->id) }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    {{-- TITLE --}}
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Blog Title
                        </label>

                        <input type="text"
                               name="title"
                               value="{{ old('title', $blog->title) }}"
                               class="w-full border rounded-lg px-4 py-2.5 text-sm">
                    </div>
                    {{-- Category -- ADD THIS BLOCK after the slug readonly field --}}
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5" for="blog_category_id">
                                Category <span class="text-gray-400 font-normal">(optional)</span>
                            </label>
                            <select id="blog_category_id" name="blog_category_id"
                                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:border-gray-800 focus:ring-2 focus:ring-gray-800/10 transition @error('blog_category_id') border-red-400 @enderror">
                                <option value="">— No Category —</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('blog_category_id', $blog->blog_category_id) == $cat->id ? 'selected' : '' }}>
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

                    {{-- CONTENT (QUILL) --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Content
                        </label>

                        <!-- Quill Editor -->
                        <div id="editor" style="height: 400px; background: white;"></div>

                        <!-- Hidden field for Laravel -->
                        <input type="hidden" name="content" id="content">
                    </div>

                    {{-- BUTTON --}}
                    <div class="flex justify-end">
                        <button type="submit"
                                class="px-5 py-2.5 bg-gray-800 text-white rounded-lg">
                            Update Blog
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
        // 1. INIT QUILL
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

        // 2. LOAD EXISTING CONTENT (IMPORTANT FIX)
        quill.root.innerHTML = {!! json_encode($blog->content) !!};

        // 3. FORM SUBMIT HANDLER
        const form = document.getElementById('blogForm');
        const contentInput = document.getElementById('content');

        form.addEventListener('submit', function () {
            contentInput.value = quill.root.innerHTML;
        });
    </script>

</x-app-layout>