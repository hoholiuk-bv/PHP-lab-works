@extends('layouts.app')

@section('content')
    <h1>Reader Details</h1>

    <p><strong>Name:</strong> {{ $reader->full_name }}</p>
    <p><strong>Email:</strong> {{ $reader->email }}</p>

    <a href="{{ route('readers.edit', $reader) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('readers.index') }}" class="btn btn-secondary">Back</a>
@endsection
