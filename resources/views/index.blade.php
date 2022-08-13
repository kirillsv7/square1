@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($posts as $post)
                    <div class="card border-light mb-4">
                        <div class="card-body">
                            <h2 class="card-title fs-4">
                                <a href="{{ route('post.show', $post->id) }}">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            <p class="card-text">{{ $post->description }}</p>
                            <p class="fs-6 mb-0 text-muted">{{ $post->publication_date }} by {{ $post->user->name }}</p>
                        </div>
                    </div>
                @endforeach

                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection
