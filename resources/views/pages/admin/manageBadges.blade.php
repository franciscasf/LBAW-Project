@extends('layouts.app')

@section('content')
@if(auth()->user() && (auth()->user()->isAdmin() || auth()->user()->isModerator()))
<div class="container">
    <h1>Manage Badges</h1>


    <div class="card mb-4">
        <div class="card-header">
            {{ isset($editBadge) ? 'Edit Badge' : 'Add New Badge' }}
        </div>
        <div class="card-body">
            <form action="{{ isset($editBadge) ? route('admin.badges.update', $editBadge->badge_id) : route('admin.badges.store') }}" method="POST">
                @csrf
                @if(isset($editBadge))
                    @method('PUT')
                @endif
                <div class="form-group">
                    <label for="name">Badge Name</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', isset($editBadge) ? $editBadge->name : '') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3" required>{{ old('description', isset($editBadge) ? $editBadge->description : '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">
                    {{ isset($editBadge) ? 'Update Badge' : 'Add Badge' }}
                </button>
            </form>
        </div>
    </div>


    @if ($badges->isEmpty())
        <p>No badges available.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($badges as $badge)
                    <tr>
                        <td>{{ $badge->name }}</td>
                        <td>{{ $badge->description }}</td>
                        <td>
             
                            <a href="{{ route('admin.badges.edit', $badge->badge_id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('admin.badges.destroy', $badge->badge_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this badge?');">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@else
<script>
    window.location.href = "{{ route('home') }}"; 
</script>
@endif
@endsection
