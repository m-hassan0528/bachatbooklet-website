@extends('layouts.user.app')

@section('content')

<section class="blog-section">
    <div class="blog-hero">
        <h1 class="blog-hero__title">Blog Categories</h1>
        <p class="blog-hero__sub">Browse posts by topic</p>
    </div>

    <div class="blog-container">
        @if($categories->count())
            <div class="blog-grid" style="padding-top: 56px;">
                @foreach($categories as $category)
                    <a href="{{ route('blog-categories.show', $category->slug) }}" class="blog-card" style="text-decoration:none;">
                        <div class="blog-card__image-wrap">
                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                                 class="blog-card__image" loading="lazy">
                            <div class="blog-card__overlay"></div>
                        </div>
                        <div class="blog-card__body">
                            <h2 class="blog-card__title">{{ $category->name }}</h2>
                            <p style="font-size:0.82rem;color:#999;margin:0;">
                                {{ $category->blogs_count }} {{ Str::plural('post', $category->blogs_count) }}
                            </p>
                            <span class="blog-card__btn" style="margin-top:auto;">
                                View Posts
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="blog-empty" style="padding-top:56px;">
                <p>No categories yet.</p>
            </div>
        @endif
    </div>
</section>

{{-- Reuse same CSS from frontend/blogs.blade.php --}}
<style>
.blog-section { min-height: 80vh; background: #f8f9fc; padding-bottom: 80px; font-family: 'Segoe UI', system-ui, sans-serif; }
.blog-hero { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); padding: 80px 20px 60px; text-align: center; position: relative; overflow: hidden; }
.blog-hero::before { content: ''; position: absolute; inset: 0; background: radial-gradient(ellipse at center, rgba(229,57,53,0.12) 0%, transparent 70%); }
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
.blog-card__title { font-size: 1.05rem; font-weight: 700; color: #1a1a2e; margin: 0; line-height: 1.45; }
.blog-card__btn { display: inline-flex; align-items: center; gap: 7px; background: #0f3460; color: #fff; text-decoration: none; padding: 9px 18px; border-radius: 7px; font-size: 0.84rem; font-weight: 600; transition: background 0.2s, gap 0.2s; align-self: flex-start; }
.blog-card:hover .blog-card__btn { background: #e53935; gap: 11px; }
.blog-empty { text-align: center; padding: 90px 20px; color: #bbb; }
@media (max-width: 640px) { .blog-grid { grid-template-columns: 1fr; } }
</style>

@endsection