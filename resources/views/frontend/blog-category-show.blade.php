@extends('layouts.user.app')

@section('content')


<section class="blog-section">
    <div class="blog-hero">
        <a href="{{ route('blogs') }}" class="blog-hero__breadcrumb">
            Blog
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            {{ $category->name }}
        </a>
        <h1 class="blog-hero__title">{{ $category->name }}</h1>
        <p class="blog-hero__sub">{{ $blogs->total() }} {{ Str::plural('post', $blogs->total()) }} in this category</p>
    </div>

    <div class="blog-container">
        @if($blogs->count())
            <div class="blog-grid" style="padding-top:56px;">
                @foreach($blogs as $blog)
                    <article class="blog-card">
                        <div class="blog-card__image-wrap">
                            <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}"
                                 class="blog-card__image" loading="lazy">
                            <div class="blog-card__overlay"></div>
                        </div>
                        <div class="blog-card__body">
                            <h2 class="blog-card__title">{{ Str::limit($blog->title, 60) }}</h2>
                            <div class="blog-card__meta">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    {{ $blog->author->name ?? 'Admin' }}
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    {{ $blog->created_at->format('M d, Y') }}
                                </span>
                            </div>
                            <a href="{{ route('blogs.show', $blog->slug) }}" class="blog-card__btn">
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
            <div class="blog-empty" style="padding-top:56px;">
                <p>No posts in this category yet.</p>
            </div>
        @endif
    </div>
</section>

<style>
.blog-section { min-height: 80vh; background: #f8f9fc; padding-bottom: 80px; font-family: 'Segoe UI', system-ui, sans-serif; }
.blog-hero { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); padding: 80px 20px 60px; text-align: center; position: relative; overflow: hidden; }
.blog-hero::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse at center, rgba(229,57,53,0.12) 0%, transparent 70%); }
.blog-hero__breadcrumb { display: inline-flex; align-items: center; gap: 6px; color: rgba(255,255,255,0.55); font-size: 0.82rem; text-decoration: none; margin-bottom: 14px; position: relative; }
.blog-hero__breadcrumb:hover { color: rgba(255,255,255,0.85); text-decoration: none; }
.blog-hero__title { color: #fff; font-size: clamp(2rem, 5vw, 3.2rem); font-weight: 800; letter-spacing: -0.02em; margin: 0 0 10px; position: relative; }
.blog-hero__sub { color: rgba(255,255,255,0.6); font-size: 1.05rem; margin: 0; position: relative; }
.blog-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
.blog-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 28px; }
.blog-card { background: #fff; border-radius: 14px; overflow: hidden; box-shadow: 0 2px 16px rgba(0,0,0,0.06); transition: transform 0.3s ease, box-shadow 0.3s ease; display: flex; flex-direction: column; }
.blog-card:hover { transform: translateY(-5px); box-shadow: 0 10px 36px rgba(0,0,0,0.11); }
.blog-card__image-wrap { position: relative; height: 210px; overflow: hidden; }
.blog-card__image { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
.blog-card:hover .blog-card__image { transform: scale(1.04); }
.blog-card__overlay { position: absolute; inset: 0; background: linear-gradient(to bottom, transparent 55%, rgba(0,0,0,0.28) 100%); pointer-events: none; }
.blog-card__body { padding: 22px; display: flex; flex-direction: column; flex: 1; gap: 10px; }
.blog-card__title { font-size: 1.05rem; font-weight: 700; color: #1a1a2e; margin: 0; line-height: 1.45; flex: 1; }
.blog-card__meta { display: flex; gap: 14px; flex-wrap: wrap; }
.blog-card__meta span { display: flex; align-items: center; gap: 5px; font-size: 0.78rem; color: #999; }
.blog-card__btn { display: inline-flex; align-items: center; gap: 7px; background: #0f3460; color: #fff; text-decoration: none; padding: 9px 18px; border-radius: 7px; font-size: 0.84rem; font-weight: 600; transition: background 0.2s, gap 0.2s; align-self: flex-start; margin-top: auto; }
.blog-card__btn:hover { background: #e53935; gap: 11px; color: #fff; text-decoration: none; }
.blog-pagination { display: flex; justify-content: center; padding: 16px 0; }
.blog-empty { text-align: center; padding: 90px 20px; color: #bbb; }
@media (max-width: 640px) { .blog-grid { grid-template-columns: 1fr; } }
</style>

@endsection