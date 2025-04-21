@extends('layouts.app')

@section('content')
    <h1>Book Details</h1>

    <p><strong>Title:</strong> {{ $book->title }}</p>
    <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
    <p><strong>Author:</strong> {{ $book->author->name ?? 'N/A' }}</p>

    <a href="{{ route('books.edit', $book) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('books.index') }}" class="btn btn-secondary">Back</a>
@endsection
