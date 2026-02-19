@extends('layouts.app')

@section('content')
<link href="{{ url('css/homePage.css') }}" rel="stylesheet">

<div class="container">
    <div class="tags-column">
        <h3>My Tags</h3>
        <ul>
            @if ($followedTags->isEmpty())
                <p>You are not following any tags.</p>
            @else
                @foreach ($followedTags as $tag)
                    <li><a href="{{ route('myFeed', ['tags' => [$tag->tag_id]]) }}">{{ $tag->acronym }}</a></li>
                @endforeach
            @endif
        </ul>
    </div>

    <div class="questions-column">
        <!-- Navigation Tabs -->
        <div class="nav-tabs">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home Page</a>
            <a href="{{ route('myFeed') }}" class="{{ request()->routeIs('myFeed') ? 'active' : '' }}">My Feed</a>
        </div>
        <div class="buttons-section">
            <button type="button" class="btn btn-bordeaux" id="openModalButton">
                Filter By Tag
            </button>
        </div>
        <div class="modal" id="exampleModalCenter" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Filter by Tags (Select Multiple)</h5>
                        <button type="button" class="close-modal" aria-label="Close">
                            &times;
                        </button>
                    </div>
                    <form method="GET" action="{{ route('myFeed') }}" id="tags-filter-form">
                        <div class="modal-body">
                            <div id="tags-container">
                                @foreach ($allTags as $tag)
                                    <div class="form-check">
                                        <input 
                                            type="checkbox" 
                                            class="form-check-input tag-checkbox" 
                                            id="tag_{{ $tag->tag_id }}" 
                                            name="tags[]" 
                                            value="{{ $tag->tag_id }}"
                                            {{ in_array($tag->tag_id, request('tags', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tag_{{ $tag->tag_id }}">
                                            - {{ $tag->acronym }} - {{ $tag->full_name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary close-modal">Close</button>
                            <button type="submit" class="btn btn-bordeaux">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="questions">
            @if ($feedQuestions->isEmpty())
                <p>No questions available for the tags you follow.</p>
            @else
                <ul>
                    @foreach ($feedQuestions as $question)
                        <li>
                            <div class="tags">
                                @foreach ($question->tags as $tag)
                                    <span>{{ $tag->acronym }} ({{ $tag->full_name }})</span>
                                @endforeach
                            </div>
                            <a href="{{ url('/questions/' . $question->question_id) }}">
                                <h3>{{ $question->title }}</h3>
                            </a>
                            <p>{{ Str::limit($question->content, 100) }}</p>
                            <small>Posted by
                                {{ $question->author->name }}
                                on
                                {{ $question->created_date ? \Carbon\Carbon::parse($question->created_date)->format('M d, Y') : 'Date not available' }}
                            </small>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('exampleModalCenter');
    const openModalButton = document.getElementById('openModalButton');
    const closeModalButtons = document.querySelectorAll('.close-modal');

    openModalButton.addEventListener('click', () => {
        modal.style.display = 'block';
    });

    closeModalButtons.forEach(button => {
        button.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    });

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
</script>

@endsection
