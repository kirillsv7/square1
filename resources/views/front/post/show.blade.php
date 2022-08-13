@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(request()->routeIs('dashboard.post.show'))
                    <div class="alert alert-info">
                        {{ _('This is preview.') }}
                        @if(!$post->is_visible)
                            {{ _('This post is not yet visible.') }}
                        @endif
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title fs-3">{{ $post->title }}</h1>
                        <p class="card-text">{{ $post->description }}</p>
                        <p class="fs-6 mb-0 text-muted">{{ $post->publication_date }} by {{ $post->user->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection