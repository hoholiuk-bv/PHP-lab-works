@extends('layouts.app')

@section('content')
    <h1>Edit Author</h1>

    <form method="POST" action="{{ route('authors.update', $author) }}">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Name:</label>
            <input name="name" value="{{ old('name', $author->name) }}" class="form-control">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('authors.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
