@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ isset($loan) ? 'Edit Loan' : 'New Loan' }}</h1>

        <form action="{{ isset($loan) ? route('loans.update', $loan) : route('loans.store') }}" method="POST">
            @csrf
            @if(isset($loan))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="book_id" class="form-label">Book</label>
                <select name="book_id" class="form-select" required>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ (old('book_id', $loan->book_id ?? '') == $book->id) ? 'selected' : '' }}>
                            {{ $book->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="reader_id" class="form-label">Reader</label>
                <select name="reader_id" class="form-select" required>
                    @foreach($readers as $reader)
                        <option value="{{ $reader->id }}" {{ (old('reader_id', $loan->reader_id ?? '') == $reader->id) ? 'selected' : '' }}>
                            {{ $reader->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="loan_date" class="form-label">Loan Date</label>
                <input type="date" name="loan_date" class="form-control" value="{{ old('loan_date', isset($loan) ? $loan->loan_date->format('Y-m-d') : '') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">{{ isset($loan) ? 'Update' : 'Create' }}</button>
        </form>
    </div>
@endsection
