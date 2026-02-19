@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Edit Question</h1>

    <form action="{{ route('questions.update', $question->question_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                class="form-control @error('title') is-invalid @enderror" 
                value="{{ old('title', $question->title) }}" 
                required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea 
                id="content" 
                name="content" 
                rows="5" 
                class="form-control @error('content') is-invalid @enderror" 
                required>{{ old('content', $question->content) }}</textarea>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="tags">Tags</label>
            <div class="tags-checkboxes">
                @foreach ($tags as $tag)
                    <div class="form-check">
                        <input 
                            class="form-check-input @error('tags') is-invalid @enderror" 
                            type="checkbox" 
                            name="tags[]" 
                            value="{{ $tag->tag_id }}" 
                            id="tag-{{ $tag->tag_id }}" 
                            {{ in_array($tag->tag_id, $question->tags->pluck('tag_id')->toArray()) ? 'checked' : '' }}>
                        <label class="form-check-label" for="tag-{{ $tag->tag_id }}">
                            {{ $tag->acronym }} - {{ $tag->full_name }}
                        </label>
                    </div>
                @endforeach
                @error('tags')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="{{ route('question.show', $question->question_id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

@endsection
