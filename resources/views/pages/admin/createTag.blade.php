@extends('layouts.app')

@section('content')
@if(auth()->user() && (auth()->user()->isAdmin() || auth()->user()->isModerator()))
<div class="container">
    <h2>Create New Tag</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.tags.store') }}">
        @csrf

        <div class="form-group">
            <label for="acronym">Acronym</label>
            <input type="text" class="form-control @error('acronym') is-invalid @enderror" name="acronym" value="{{ old('acronym') }}" required>
            @error('acronym')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="full_name">Full Name</label>
            <input type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ old('full_name') }}" required>
            @error('full_name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>
@else
<script>
    window.location.href = "{{ route('home') }}"; 
</script>
@endif
@endsection
