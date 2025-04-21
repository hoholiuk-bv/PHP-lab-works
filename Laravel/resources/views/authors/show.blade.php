@extends('layouts.app')

@section('content')
    <h1>Author Details</h1>

    <p><strong>Name:</strong> {{ $author->name }}</p>

    <a href="{{ route('authors.edit', $author) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('authors.index') }}" class="btn btn-secondary">Back</a>
@endsection
