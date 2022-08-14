@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Posts') }}</div>
                    <div class="card-body">
                        <form action="{{ route('dashboard.post.store') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input class="form-control @error('title') is-invalid @enderror" id="title" type="text"
                                       name="title" placeholder="{{ __('Post title') }}" value="{{ old('title') }}">
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description" name="description"
                                          placeholder="{{ __('Post description') }}">{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="publication-date" class="form-label">Publication date</label>
                                <input class="form-control @error('publication_date') is-invalid @enderror"
                                       id="publication-date" type="datetime-local" name="publication_date"
                                       value="{{ old('publication_date') }}">
                                @error('publication_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button class="btn btn-primary" type="submit">
                                {{ __('Save') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection