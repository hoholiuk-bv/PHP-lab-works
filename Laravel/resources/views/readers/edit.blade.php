@extends('layouts.app')

@section('content')
    <h1>Edit Reader</h1>

    <form method="POST" action="{{ route('readers.update', $reader) }}">
        @csrf @method('PUT')

        <div class="form-group">
            <label>Name:</label>
            <input name="full_name" value="{{ old('full_name', $reader->full_name) }}" class="form-control" type="text" />
            @error('full_name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input name="email" value="{{ old('email', $reader->email) }}" class="form-control" type="email" />
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('readers.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
