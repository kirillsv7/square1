@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Posts') }}</div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-baseline justify-content-between">
                            <a class="btn btn-primary mb-2" href="{{ route('dashboard.post.create') }}">
                                {{ __('Add post') }}
                            </a>
                            <select class="form-select mb-2 w-auto" id="post-order">
                                <option value="0">{{ __('Newest first') }}</option>
                                <option value="1"
                                        @if(request()->query('order') == 1) selected @endif>{{ __('Oldest first') }}
                                </option>
                            </select>
                        </div>
                        <table class="table">
                            <thead>
                            <tr>
                                <td>{{ __('ID') }}</td>
                                <td>{{ __('Title') }}</td>
                                <td>{{ __('Publication date') }}</td>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>
                                        <a class="d-inline-block"
                                           href="{{ route(!$post->is_visible ? 'dashboard.post.show' : 'post.show', $post->id) }}"
                                           target="_blank">
                                            {{ $post->title }}
                                        </a>
                                        @if(!$post->is_visible)
                                            <svg class="ms-2" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                                                <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                                                <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
                                                <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
                                            </svg>
                                        @endif
                                    </td>
                                    <td>{{ $post->publication_date }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">
                                        {{ __('Create your first post') }}
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{ $posts->links() }}
                    </div>
                </div>
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