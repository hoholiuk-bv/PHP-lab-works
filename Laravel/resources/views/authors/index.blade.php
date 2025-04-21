@extends('layouts.app')

@section('content')
    <h1>Authors</h1>

    <a href="{{ route('authors.create') }}" class="btn btn-primary mb-3">Add Author</a>

    <form method="GET" action="{{ route('authors.index') }}" class="mb-3">
        <input type="text" name="name" placeholder="Filter by name" value="{{ request('name') }}">
        <input type="number" name="itemsPerPage" value="{{ request('itemsPerPage', 10) }}" min="1" style="width:100px;">
        <button type="submit" class="btn btn-sm btn-secondary">Filter</button>
    </form>

    @if($authors->count())
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($authors as $author)
                <tr>
                    <td>{{ $author->name }}</td>
                    <td>
                        <a href="{{ route('authors.show', $author) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('authors.edit', $author) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('authors.destroy', $author) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this author?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $authors->withQueryString()->links() }}
    @else
        <p>No authors found.</p>
    @endif
@endsection
