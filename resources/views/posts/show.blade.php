@extends('layouts.blog')
@section('content')

<div class="container">
    <div class="row justify-content-center mt-3 mb-5">
        <div class="col-md-9">
            <h1 class="mb-3">{{ $post->title }}</h1>
            <p>By: <a href="{{ route('posts') . "?author=" . $post->author->name }}" class="text-decoration-none">{{ $post->user->name }}</a> | Category: <a href="{{ route('posts') . "?category=" . $post->category->slug }}" class="text-decoration-none">{{ $post->category->name }}</a></p>
            
            @if($post->image)
                <div style="max-height: 350px; overflow: hidden;">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->category->name }}" class="img-fluid">
                </div>
            @else
                <img src="https://source.unsplash.com/1200x400?{{ $post->category->name }}" alt="{{ $post->category->name }}" class="img-fluid">
            @endif

            <article class="my-3 fs-5">

                {!! $post->post !!}

            </article>

            <div class="mt-4">
                <p>Tags: 
                    @foreach($post->tags as $index => $tag)
                        @if($index %2 == 0)
                            <a href="{{ route('posts') . "?tag=" . $tag->slug }}" class="btn btn-outline-primary btn-sm">{{ $tag->name }}</a>
                        @else
                            <a href="{{ route('posts') . "?tag=" . $tag->slug }}" class="btn btn-outline-success btn-sm">{{ $tag->name }}</a>
                        @endif
                    @endforeach
                </p>
            </div>

            
            <a href="/posts" class="d-block mt-5">Back to Posts</a>
        </div>
    </div>
</div>

@endsection