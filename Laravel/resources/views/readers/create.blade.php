@extends('layouts.app')

@section('content')
    <h1>Create Reader</h1>

    <form method="POST" action="{{ route('readers.store') }}">
        @csrf

        <div class="form-group">
            <label>Name:</label>
            <input name="full_name" value="{{ old('full_name') }}" class="form-control" type="text" />
            @error('full_name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input name="email" value="{{ old('email') }}" class="form-control" type="email" />
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('readers.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
