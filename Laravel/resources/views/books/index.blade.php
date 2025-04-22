@extends('layouts.app')

@section('content')
    <h1>Books</h1>

    <a href="{{ route('books.create') }}" class="btn btn-primary mb-3">Add Book</a>

    <form method="GET" action="{{ route('books.index') }}" class="mb-3">
        <input type="text" name="title" placeholder="Filter by title" value="{{ request('title') }}">
        <input type="text" name="isbn" placeholder="Filter by ISBN" value="{{ request('isbn') }}">
        <select name="author_id">
            <option value="">Select Author</option>
            @foreach($authors as $author)
                <option value="{{ $author->id }}" {{ request('author_id') == $author->id ? 'selected' : '' }}>
                    {{ $author->name }}
                </option>
            @endforeach
        </select>
        <input type="number" name="itemsPerPage" value="{{ request('itemsPerPage', 10) }}" min="1" style="width:100px;">
        <button type="submit" class="btn btn-sm btn-secondary">Filter</button>
    </form>

    @if($books->count())
        <table class="table">
            <thead>
            <tr>
                <th>Title</th>
                <th>ISBN</th>
                <th>Author</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->isbn }}</td>
                    <td>{{ $book->author->name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('books.show', $book) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('books.edit', $book) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('books.destroy', $book) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this book?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $books->withQueryString()->links() }}
    @else
        <p>No books found.</p>
    @endif
@endsection
