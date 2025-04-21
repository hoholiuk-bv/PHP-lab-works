@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Loans</h1>

        <form method="GET" action="{{ route('loans.index') }}" class="mb-4">
            <div class="row g-2">
                <div class="col">
                    <select name="book_id" class="form-select">
                        <option value="">All Books</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}" {{ request('book_id') == $book->id ? 'selected' : '' }}>
                                {{ $book->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <select name="reader_id" class="form-select">
                        <option value="">All Readers</option>
                        @foreach($readers as $reader)
                            <option value="{{ $reader->id }}" {{ request('reader_id') == $reader->id ? 'selected' : '' }}>
                                {{ $reader->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>

        <a href="{{ route('loans.create') }}" class="btn btn-success mb-3">New Loan</a>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Book</th>
                <th>Reader</th>
                <th>Loan Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($loans as $loan)
                <tr>
                    <td>{{ $loan->book->title ?? 'N/A' }}</td>
                    <td>{{ $loan->reader->full_name ?? 'N/A' }}</td>
                    <td>{{ $loan->loan_date->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('loans.show', $loan) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('loans.edit', $loan) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('loans.destroy', $loan) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this loan?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $loans->withQueryString()->links() }}
    </div>
@endsection
