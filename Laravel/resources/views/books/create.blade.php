@extends('layouts.app')

@section('content')
    <h1>Add New Book</h1>

    <form method="POST" action="{{ route('books.store') }}">
        @csrf

        <div class="form-group">
            <label>Title:</label>
            <input name="title" value="{{ old('title') }}" class="form-control">
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label>ISBN:</label>
            <input name="isbn" value="{{ old('isbn') }}" class="form-control">
            @error('isbn') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label>Author:</label>
            <select name="author_id" class="form-control">
                <option value="">-- Choose author --</option>
                @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>
                        {{ $author->name }}
                    </option>
                @endforeach
            </select>
            @error('author_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
