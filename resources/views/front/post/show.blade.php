@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(request()->routeIs('dashboard.post.show'))
                    <a class="btn btn-primary mb-2" href="{{ url()->previous() }}">{{ __('Back to dashboard') }}</a>
                    <div class="alert alert-info">
                        {{ __('This post is not yet visible.') }}
                    </div>
                @endif
                <div class="card border-light">
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
