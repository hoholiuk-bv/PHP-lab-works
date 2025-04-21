@extends('layouts.app')

@section('content')
    <h1>Edit Book</h1>

    <form method="POST" action="{{ route('books.update', $book) }}">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Title:</label>
            <input name="title" value="{{ old('title', $book->title) }}" class="form-control">
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label>ISBN:</label>
            <input name="isbn" value="{{ old('isbn', $book->isbn) }}" class="form-control">
            @error('isbn') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label>Author:</label>
            <select name="author_id" class="form-control">
                @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ $book->author_id == $author->id ? 'selected' : '' }}>
                        {{ $author->name }}
                    </option>
                @endforeach
            </select>
            @error('author_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
