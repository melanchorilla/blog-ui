@extends('layouts.blog')
@section('content')

<div class="container mt-5">
    <div class="row min-vh-100">
    @if($posts->count())
        <!-- Blog entries-->
        <div class="col-lg-8">
            @if($posts[0])
            <!-- Featured blog post-->
            <div class="card mb-4">
                @if($posts[0]->image)
                    <img src="{{ asset('storage/' . $posts[0]->image) }}" alt="{{ $posts[0]->category->name }}" class="card-img-top">
                @else
                    <img src="https://dummyimage.com/850x350/dee2e6/6c757d.jpg" alt="{{ $posts[0]->category->name }}" class="card-img-top">
                @endif
                <div class="card-body">
                    <div class="small text-muted">{{ $posts[0]->created_at->diffForHumans() }}</div>
                    <h2 class="card-title">{{ $posts[0]->title }}</h2>
                    {{-- <p class="card-text">{!! Str::limit($posts[0]->post, 100) !!}</p> --}}
                    <a class="btn btn-primary mt-2" href="{{ route('post.show', $posts[0]->slug) }}">Read more →</a>
                </div>
            </div>
            @endif

            <!-- Nested row for non-featured blog posts-->
            <div class="row">
                @foreach ($posts->skip(1) as $post)
                <div class="col-lg-6">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->category->name }}" class="card-img-top">
                    @else
                        <img src="https://dummyimage.com/700x350/dee2e6/6c757d.jpg" alt="{{ $post->category->name }}" class="card-img-top">
                    @endif
                    <div class="card-body">
                        <div class="small text-muted">{{ $post->created_at->diffForHumans() }}</div>
                        <h2 class="card-title h4">{{ $post->title }}</h2>
                        {{-- <p class="card-text">{!! Str::limit($post->post, 50) !!}</p> --}}
                        <a class="btn btn-primary mt-2" href="{{ route('post.show', $post->slug) }}">Read more →</a>
                    </div>
                </div>      
                @endforeach
                <div class="my-2">
                    {{ $posts->links() }}
                </div>
            </div>

        </div>
        <!-- Side widgets-->
        <div class="col-lg-4">
            <form action="{{ route('posts') }}" method="GET">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('author'))
                    <input type="hidden" name="author" value="{{ request('author') }}">
                @endif
                @if(request('tag'))
                    <input type="hidden" name="tag" value="{{ request('tag') }}">
                @endif
                <!-- Search widget-->
                <div class="card mb-4">
                    <div class="card-header">Search</div>
                    <div class="card-body">
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" value="{{ request('search') }}" name="search" />
                            <button class="btn btn-primary" id="button-search" type="submit">Go!</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Categories widget-->
            <div class="card mb-4">
                <div class="card-header">Categories</div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-sm-6">
                            <ul class="list-unstyled mb-0">
                            @foreach($categories as $index => $category)
                                @if($index %2 == 0)
                                    <li><a href="{{ route('posts') . "?category=" . $category->slug }}">{{ $category->name }}</a></li>
                                @endif
                            @endforeach
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul class="list-unstyled mb-0">
                            @foreach($categories as $index => $category)
                                @if($index %2 == 1)
                                    <li><a href="{{ route('posts') . "?category=" . $category->slug }}">{{ $category->name }}</a></li>
                                @endif
                            @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <p class="text-center fs-4">No post found.</p>
    @endif
    </div>
</div>
@endsection