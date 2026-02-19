@extends('layouts.app')

@section('content')

<div class="container">
    <h1 class="mb-4">Create A New Question</h1>

    <form action="{{ route('questions.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="tags">Tags (Select between 1 and 5)</label>
            <div id="tags-container">
                @foreach ($tags as $tag)
                    <div class="form-check">
                        <input 
                            type="checkbox" 
                            class="form-check-input tag-checkbox" 
                            id="tag_{{ $tag->tag_id }}" 
                            name="tags[]" 
                            value="{{ $tag->tag_id }}" 
                            {{ is_array(old('tags')) && in_array($tag->tag_id, old('tags')) ? 'checked' : '' }}>
                        <label class="form-check-label" for="tag_{{ $tag->tag_id }}">
                            {{ $tag->acronym }} - {{ $tag->full_name }}
                        </label>
                    </div>
                @endforeach
            </div>
            @error('tags')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="title">Question Title</label>
            <input 
                type="text" 
                class="form-control @error('title') is-invalid @enderror" 
                id="title" 
                name="title" 
                value="{{ old('title') }}" 
                required 
                placeholder="Type the question title">
            @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="content">Question Content</label>
            <textarea 
                class="form-control rich-text-editor @error('content') is-invalid @enderror" 
                id="content" 
                name="content" 
                rows="10" 
                required>{{ old('content') }}</textarea>
            @error('content')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Criar Pergunta</button>
    </form>
</div>

@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content');
        const tagCheckboxes = document.querySelectorAll('.tag-checkbox');
        tagCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const selectedTags = Array.from(tagCheckboxes).filter(cb => cb.checked);
                if (selectedTags.length > 5) {
                    alert('You can only select 5 tags per question!');
                    checkbox.checked = false; 
                } else if (selectedTags.length === 0) {
                    alert('You must select at least 1 tag for this question!');
                }
            });
        });
    </script>
@endsection
