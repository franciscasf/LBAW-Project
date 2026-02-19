@extends('layouts.app')

@section('content')
@if(auth()->user() && (auth()->user()->isAdmin() || auth()->user()->isModerator()))
<div class="container">
    <h2>Edit Tag</h2>
    <form method="POST" action="{{ route('admin.tags.update', $tag->tag_id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="acronym">Acronym</label>
            <input type="text" class="form-control" name="acronym" value="{{ $tag->acronym }}" required>
        </div>

        <div class="form-group">
            <label for="full_name">Full Name</label>
            <input type="text" class="form-control" name="full_name" value="{{ $tag->full_name }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" rows="3">{{ $tag->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@else
<script>
    window.location.href = "{{ route('home') }}"; // redirect to a route
</script>
@endif
@endsection
