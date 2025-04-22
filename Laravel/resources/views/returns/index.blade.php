@extends('layouts.app')

@section('content')

    <form method="GET" action="{{ route('returns.index') }}" class="mb-3">
        <input type="number" name="loan_id" value="{{ request('loan_id') }}" class="form-control" placeholder="Filter by Loan ID" />
        <input type="date" name="return_date_from" value="{{ request('return_date_from') }}" class="form-control" placeholder="Filter by Return Date From" />
        <input type="date" name="return_date_to" value="{{ request('return_date_to') }}" class="form-control" placeholder="Filter by Return Date To" />
        <input type="number" name="itemsPerPage" value="{{ request('itemsPerPage', 10) }}" min="1" style="width:100px;">
        <button type="submit" class="btn btn-sm btn-secondary">Filter</button>
    </form>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Returned Books</h1>
        <a href="{{ route('returns.create') }}" class="btn btn-primary">Register Return</a>
    </div>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Loan ID</th>
            <th>Book Title</th>
            <th>Reader</th>
            <th>Return Date</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($returnBooks as $return)
            <tr>
                <td>{{ $return->loan_id }}</td>
                <td>{{ $return->loan->book->title ?? '—' }}</td>
                <td>{{ $return->loan->reader->full_name ?? '—' }}</td>
                <td>{{ $return->return_date->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('returns.show', $return) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('returns.edit', $return) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('returns.destroy', $return) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $returnBooks->appends(request()->query())->links() }}
    </div>
@endsection
