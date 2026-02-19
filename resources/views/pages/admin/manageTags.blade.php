@extends('layouts.app')

@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('css/manage-tags.css') }}">
</head>

@if(auth()->user() && (auth()->user()->isAdmin() || auth()->user()->isModerator()))
    <div class="container">
        <div id="manage-tags">
            <h1>Manage Tags</h1>

            <form action="{{ route('admin.tags.create') }}" method="GET" style="display:inline;" id="new-tag">
                <button type="submit" class="btn btn-bordeaux mb-3" >Create New Tag</button>
            </form>
        </div>

        @if ($tags->isEmpty())
            <p>No tags available.</p>
        @else
            <table class="table">
                <thead>
                    <tr id="table-header">
                        <th>ID</th>
                        <th>Acronym</th>
                        <th>Full Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tags as $tag)
                        <tr id="tag">
                            <td>{{ $tag->tag_id }}</td>
                            <td>{{ $tag->acronym }}</td>
                            <td>{{ $tag->full_name }}</td>
                            <td>
                                <form action="{{ route('admin.tags.edit', $tag->tag_id) }}" method="GET" style="display:inline;">
                                    <button type="submit" class="btn btn-sm btn-primary" id="edit">Edit</button>
                                </form>
                                <form method="POST" action="{{ route('admin.tags.destroy', $tag->tag_id) }}"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" id="delete">
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