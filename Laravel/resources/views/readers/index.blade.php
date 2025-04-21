@extends('layouts.app')

@section('content')
    <h1>Readers</h1>

    <a href="{{ route('readers.create') }}" class="btn btn-primary mb-3">Add Reader</a>

    <form method="GET" action="{{ route('readers.index') }}" class="mb-3">
        <input type="text" name="full_name" value="{{ request('full_name') }}" class="form-control" placeholder="Filter by Name" />
        <input type="text" name="email" value="{{ request('email') }}" class="form-control" placeholder="Filter by Email" />
        <input type="number" name="itemsPerPage" value="{{ request('itemsPerPage', 10) }}" min="1" style="width:100px;">
        <button type="submit" class="btn btn-sm btn-secondary">Filter</button>
    </form>

    @if($readers->count())
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($readers as $reader)
                <tr>
                    <td>{{ $reader->full_name }}</td>
                    <td>{{ $reader->email }}</td>
                    <td>
                        <a href="{{ route('readers.show', $reader) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('readers.edit', $reader) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('readers.destroy', $reader) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this reader?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $readers->withQueryString()->links() }}
    @else
        <p>No readers found.</p>
    @endif
@endsection
