@extends('layouts.app')

@section('content')


<head>
    
    <link href="{{ url('css/homePage.css') }}" rel="stylesheet">
    <script src="{{ asset('js/morequestions.js') }}"></script>
</head>

<div class="container">
    <div class="tags-column">
        <h3>Explore Tags</h3>
        <ul>
            @foreach ($allTags as $tag)
            <li><a href="{{ route('questions.filterByTags', ['tags' => [$tag->tag_id]]) }}">{{ $tag->acronym }}</a></li>
            @endforeach
        </ul>
    </div>
    <div class="questions-column">
        <div class="nav-tabs">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home Page</a>
            @auth
            <a href="{{ route('myFeed') }}" class="{{ request()->routeIs('myFeed') ? 'active' : '' }}">My Feed</a>
            @endauth
        </div>
        <div class="buttons-section">
            <a href="#" class="btn btn-bordeaux" data-toggle="modal" data-target="#exampleModalCenter">Filter By Tag</a>
            @auth
            <a href="{{ route('questions.create') }}"  class="btn btn-bordeaux floating-button">New Question</a>
            @if (auth()->user()->isAdmin())
            <a href="{{ route('user_administration') }}" class="btn btn-bordeaux">Administer Users</a>
            @endif
            @if (auth()->user()->isAdmin() || auth()->user()->isModerator())
            <a href="{{ route('admin.tags.manage') }}" class="btn btn-bordeaux">Manage Tags</a>
            @endif
            @if (auth()->user()->isAdmin() || auth()->user()->isModerator())
                <a href="{{ route('admin.badges.manage') }}" class="btn btn-bordeaux">Manage Badges</a>
            @endif

            @if (auth()->user()->isAdmin() || auth()->user()->isModerator())
                <a href="{{ route('admin.verificationRequests') }}" class="btn btn-bordeaux">View Verification Requests</a>
            @endif


            @endauth
        </div>

        <div class="sorting-section">
            <form method="GET" action="{{ route('home') }}">
                <label for="sort">Sort By:</label>
                <select name="sort" id="sort" onchange="this.form.submit()">
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="popularity" {{ request('sort') === 'popularity' ? 'selected' : '' }}>Popularity</option>
                </select>
            </form>
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
                        <form method="GET" action="{{ route('questions.filterByTags') }}" id="tags-filter-form">
                            <div class="modal-body">
                                <div id="tags-container">
                                    @foreach ($allTags as $tag)
                                    <div class="form-check">
                                        <input
                                            type="checkbox"
                                            class="form-check-input"
                                            id="tag_{{ $tag->tag_id }}"
                                            name="tags[]"
                                            value="{{ $tag->tag_id }}"
                                            {{ in_array($tag->tag_id, request('tags', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tag_{{ $tag->tag_id }}">
                                            {{ $tag->acronym }} - {{ $tag->full_name }}
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
    @if ($latestQuestions->isEmpty())
    <p>No questions available at the moment.</p>
    @else
    <ul id="question-list">
        @foreach ($latestQuestions as $question)
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
<div id="loader" style="text-align:center; display:none;">
    <p>Loading...</p>
</div>

    </div>
</div>
<script>
    const modal = document.getElementById('exampleModalCenter');
    const openModalButtons = document.querySelectorAll('[data-toggle="modal"]');
    const closeModalButtons = document.querySelectorAll('.close-modal');

    openModalButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            modal.style.display = 'block';
        });
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