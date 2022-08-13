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
                                <input class="form-control" id="title" type="text" name="title"
                                       placeholder="{{ _('Post title') }}" value="{{ old('title') }}">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description"
                                          placeholder="{{ _('Post description') }}">{{ old('description') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="publication-date" class="form-label">Publication date</label>
                                <input class="form-control" id="publication-date" type="datetime-local"
                                       name="publication_date" value="{{ old('publication_date') }}">
                            </div>
                            <button class="btn btn-primary" type="submit">
                                {{ _('Save') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection