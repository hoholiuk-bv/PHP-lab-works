@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Loans</h1>

        <form method="GET" action="{{ route('loans.index') }}">
            <div>
                <label for="book_id">Book</label>
                <select name="book_id">
                    <option value="">Select a book</option>
                    @foreach ($books as $book)
                        <option value="{{ $book->id }}" {{ request('book_id') == $book->id ? 'selected' : '' }}>{{ $book->title }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="reader_id">Reader</label>
                <select name="reader_id">
                    <option value="">Select a reader</option>
                    @foreach ($readers as $reader)
                        <option value="{{ $reader->id }}" {{ request('reader_id') == $reader->id ? 'selected' : '' }}>{{ $reader->full_name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="loan_date_from">Loan Date From</label>
                <input type="date" name="loan_date_from" value="{{ request('loan_date_from') }}">
            </div>

            <div>
                <label for="loan_date_to">Loan Date To</label>
                <input type="date" name="loan_date_to" value="{{ request('loan_date_to') }}">
            </div>

            <div>
                <button type="submit">Search</button>
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
