<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Blogs Posts') }}
            </h2>
            <a href="{{ route('admin-blogs.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __(' + Add Blogs') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

       
        {{-- Flash Message --}}
        @if(session('success'))
            <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 mb-5 text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">#</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Image</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Title</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Slug</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Added By</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($blogs as $blog)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">
                                    <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}"
                                         class="w-10 h-10 object-cover rounded-md">
                                </td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-800">
                                    {{ Str::limit($blog->title, 48) }}
                                </td>
                                <td class="px-4 py-3">
                                    <code class="text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded">{{ $blog->slug }}</code>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ $blog->author->name ?? '—' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $blog->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        {{-- View --}}
                                        <a href="{{ route('blogs.show', $blog->slug) }}" target="_blank"
                                           class="w-8 h-8 flex items-center justify-center rounded-md bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition" title="View">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </a>
                                        {{-- Edit --}}
                                        <a href="{{ route('admin-blogs.edit', $blog->id) }}"
                                           class="w-8 h-8 flex items-center justify-center rounded-md bg-yellow-50 text-yellow-600 hover:bg-yellow-500 hover:text-white transition" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </a>
                                        {{-- Delete --}}
                                        <form action="{{ route('admin-blogs.destroy', $blog->id) }}" method="POST"
                                              onsubmit="return confirm('Delete this blog post?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="w-8 h-8 flex items-center justify-center rounded-md bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition" title="Delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center text-gray-400 text-sm">
                                    No blog posts found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-5 flex justify-end">
            {{ $blogs->links() }}
        </div>

    </div>
</div>
</x-app-layout>