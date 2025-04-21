@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Loan Details</h1>
        <ul class="list-group mb-3">
            <li class="list-group-item"><strong>Book:</strong> {{ $loan->book->title }}</li>
            <li class="list-group-item"><strong>Reader:</strong> {{ $loan->reader->full_name }}</li>
            <li class="list-group-item"><strong>Loan Date:</strong> {{ $loan->loan_date->format('Y-m-d') }}</li>
        </ul>
        <a href="{{ route('loans.edit', $loan) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('loans.index') }}" class="btn btn-secondary">Back</a>
    </div>
@endsection
