@extends('layouts.user.app')

@section('content')



<!-- Page Banner -->
<section class="category-banner relative  bg-gray-900">
    <img src="{{ asset('images/category-banner.jpg') }}"
         class="absolute inset-0 w-full h-full object-cover opacity-60"
         alt="Categories">
    <div class="relative z-10 flex items-center justify-center h-full">
        <h1 class="text-4xl font-bold text-white">All Blogs</h1>
    </div>
</section>

<!-- Categories Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

      <h1>BLOGS</h1>

    </div>
     <div class="blog-container">
        @if($blogs->count())
            <div class="blog-grid">
                @foreach($blogs as $blog)
                    <article class="blog-card">
                        <div class="blog-card__image-wrap">
                            <img
                                src="{{ $blog->image_url }}"
                                alt="{{ $blog->title }}"
                                class="blog-card__image"
                                loading="lazy"
                            >
                            <div class="blog-card__overlay"></div>
                        </div>

                        <div class="blog-card__body">
                            <h2 class="blog-card__title">
                                {{ Str::limit($blog->title, 60) }}
                            </h2>
                            <a href="{{ route('blogs.show', $blog->slug) }}" class="blog-card-btn1">
                                Read More
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="blog-pagination">
                {{ $blogs->links() }}
            </div>

        @else
            <div class="blog-empty">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                <p>No blog posts yet. Check back soon!</p>
            </div>
        @endif
    </div>
</section>

@endsection
