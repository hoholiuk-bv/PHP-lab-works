@extends('layouts.app')

@section('content')
    <h1>Register a Book Return</h1>

    <form action="{{ route('returns.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="loan_id">Loan:</label>
            <select name="loan_id" class="form-control">
                @foreach ($loans as $loan)
                    <option value="{{ $loan->id }}">
                        [#{{ $loan->id }}] {{ $loan->book->title }} - {{ $loan->reader->full_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="return_date">Return Date:</label>
            <input type="date" name="return_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Register Return</button>
    </form>
@endsection
