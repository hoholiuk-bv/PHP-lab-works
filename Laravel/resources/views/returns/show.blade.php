@extends('layouts.app')

@section('content')
    <h1>Return Details</h1>

    <p><strong>Loan ID:</strong> {{ $return->loan_id }}</p>
    <p><strong>Book:</strong> {{ $return->loan->book->title ?? '—' }}</p>
    <p><strong>Reader:</strong> {{ $return->loan->reader->full_name ?? '—' }}</p>
    <p><strong>Return Date:</strong> {{ $return->return_date->format('Y-m-d') }}</p>

    <a href="{{ route('returns.index') }}" class="btn btn-secondary">Back</a>
@endsection
