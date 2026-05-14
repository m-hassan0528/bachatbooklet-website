@extends('layouts.user.app')

@section('content')

<div class="bshow__body">

    <div class="bshow__content-wrapper">

        @if($blog->image_url)
            <img src="{{ $blog->image_url }}"
                 alt="{{ $blog->title }}"
                 class="bshow__image">
        @endif

        <h1 class="bshow__title">{{ $blog->title }}</h1>

        {{-- Content --}}
        <div class="bshow__content">
            {!! $blog->content !!}
        </div>

        <div class="bshow__footer">
            <a href="{{ route('blogs') }}" class="bshow__back-btn">
                Back to All Blogs
            </a>
        </div>

    </div>

</div>


@endsection
