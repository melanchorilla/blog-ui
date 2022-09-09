@extends('layouts.dashboard')
@section('content')

<div class="container">
    <div class="row my-4">
        <div class="col-md-4">
            <form action="{{ route('dashboard') }}" method="GET">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('author'))
                    <input type="hidden" name="author" value="{{ request('author') }}">
                @endif
                @if(request('tag'))
                    <input type="hidden" name="tag" value="{{ request('tag') }}">
                @endif

                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Enter search term.." aria-label="Recipient's username" aria-describedby="basic-addon2" value="{{ request('search') }}" name="search">
                    <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                    </div>
                </div>

            </form>
        </div>
        <div class="col-md-12">
            <div class="table-responsive mb-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td><a href="{{ route('dashboard.show', $post->slug) }}">{{ $post->title }}</a></td>
                                <td><a href="{{ route('dashboard') . '?category=' . $post->category->slug }}">{{ $post->category->name }}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $posts->links() }}
        </div>
    </div>
</div>



@endsection