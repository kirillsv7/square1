@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-end">
                    <select class="form-select mb-3 w-auto" id="post-order">
                        <option value="0">Newest first</option>
                        <option value="1" @if(request()->query('order') == 1) selected @endif>Oldest first</option>
                    </select>
                </div>
                @foreach($posts as $post)
                    <div class="card border-light mb-4">
                        <div class="card-body">
                            <h2 class="card-title fs-4">
                                <a href="{{ route('post.show', $post->id) }}">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            <p class="card-text">{{ $post->description }}</p>
                            <p class="fs-6 mb-0 text-muted">{{ $post->publication_date_for_front }}
                                by {{ $post->user->name }}</p>
                        </div>
                    </div>
                @endforeach

                {{ $posts->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('post-order').addEventListener('change', function () {
            const url = new URL(document.URL)
            url.searchParams.set('order', this.value)
            window.location.href = url.toString()
        });
    </script>
@endpush
