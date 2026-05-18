@extends('layouts.user.app')

@section('content')
{{-- Hero --}}
<div class="blog-hero">
    <h1 class="blog-hero__title">Our <em>Blogs</em></h1>
    <p class="blog-hero__sub">
        Insights, stories and updates from our team
    </p>
</div>

{{-- Filter Bar --}}
<div class="blog-filter-bar">
    <div class="blog-container" style="padding-top:0;padding-bottom:0;">
        <div class="blog-filter-inner">

            <span class="blog-filter-label">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="4" y1="6" x2="20" y2="6"/>
                    <line x1="8" y1="12" x2="16" y2="12"/>
                    <line x1="11" y1="18" x2="13" y2="18"/>
                </svg>
                Filter by Category
            </span>

            {{-- CATEGORY DROPDOWN --}}
            <select class="blog-filter-select" onchange="filterCategory(this)">
                <option value="{{ route('blogs') }}">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ route('blogs.category', $cat->slug) }}"
                        {{ isset($selectedCategory) && $selectedCategory->slug === $cat->slug ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            {{-- CLEAR FILTER --}}
            @if(isset($selectedCategory))
                <a href="{{ route('blogs') }}" class="blog-filter-clear">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                    Clear
                </a>
            @endif

        </div>
    </div>
</div>

{{-- SEARCH BAR --}}
<div class="blog-search-wrap">
    <form method="GET"
          action="{{ isset($selectedCategory)
                    ? route('blogs.category', $selectedCategory->slug)
                    : route('blogs') }}">
        <div class="blog-search-box">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8585a0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search blogs..."
                class="blog-search-input"
            >

            <button type="submit" class="blog-search-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <span>Search</span>
            </button>
        </div>
    </form>
</div>

<!-- Blogs Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                    <polyline points="12 5 19 12 12 19"/>
                                </svg>
                            </a>
                        </div>

                    </article>
                @endforeach
            </div>

            <div class="blog-pagination">
                {{ $blogs->links() }}
            </div>

        @else

            <div class="blog-grid">
                <div class="blog-empty">
                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                    <p>No blog posts found.</p>
                </div>
            </div>

        @endif

    </div>
</section>

{{-- CATEGORY FILTER JS — unchanged --}}
<script>
    function filterCategory(select) {
        window.location.href = select.value;
    }
</script>

@endsection