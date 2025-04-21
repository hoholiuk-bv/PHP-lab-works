@extends('layouts.app')

@section('content')
    <h1>Add New Author</h1>

    <form method="POST" action="{{ route('authors.store') }}">
        @csrf

        <div class="form-group">
            <label>Name:</label>
            <input name="name" value="{{ old('name') }}" class="form-control">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('authors.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
