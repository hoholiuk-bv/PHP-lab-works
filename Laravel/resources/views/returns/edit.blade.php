@extends('layouts.app')

@section('content')
    <h1>Edit Return</h1>

    <form action="{{ route('returns.update', $return) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="loan_id">Loan:</label>
            <select name="loan_id" class="form-control">
                @foreach ($loans as $loan)
                    <option value="{{ $loan->id }}" {{ $return->loan_id == $loan->id ? 'selected' : '' }}>
                        [#{{ $loan->id }}] {{ $loan->book->title }} - {{ $loan->reader->full_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="return_date">Return Date:</label>
            <input type="date" name="return_date" class="form-control" value="{{ $return->return_date->format('Y-m-d') }}">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
@endsection
