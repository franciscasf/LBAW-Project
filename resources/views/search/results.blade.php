@extends('layouts.app')

<head>
    <link href="{{ url('css/result.css') }}" rel="stylesheet">
    <script src="{{ asset('js/search-page.js') }}"></script>
</head>
@section('content')
<div class="container">
    <h1>Search Results for "{{ $search }}"</h1>

    <div class="filter-buttons">
        <a href="{{ route('search') }}?search={{ $search }}&filter=all"
            class="btn {{ $filter == 'all' ? 'active' : '' }}">All</a>
        <a href="{{ route('search') }}?search={{ $search }}&filter=questions"
            class="btn {{ $filter == 'questions' ? 'active' : '' }}">Questions</a>
        <a href="{{ route('search') }}?search={{ $search }}&filter=users"
            class="btn {{ $filter == 'users' ? 'active' : '' }}">Users</a>
        <a href="{{ route('search') }}?search={{ $search }}&filter=verified_answers"
            class="btn {{ $filter == 'verified_answers' ? 'active' : '' }}">Questions with Verified Answers</a>
    </div>


    <div id="content">
        <div class="result-columns">
            <div class="column">
                @if($filter == 'all' || $filter == 'questions' || $filter == 'verified_answers')
                    <h3>
                        @if($filter == 'verified_answers')
                            Questions with Verified Answers
                        @else
                            Questions
                        @endif
                    </h3>
                    @if ($questions->isEmpty())
                        <p>No questions found.</p>
                    @else
                        <ul id="questions">
                            @foreach ($questions as $question)
                                <li
                                    data-has-verified-answer="{{ $question->answers()->where('verified', true)->exists() ? 'true' : 'false' }}">
                                    <div class="tags">
                                        @foreach ($question->tags as $tag)
                                            <span>{{ $tag->acronym }} ({{ $tag->full_name }})</span>
                                        @endforeach
                                    </div>
                                    <a href="{{ route('question.show', $question) }}">
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
                @endif
            </div>
            <div class="column">
                @if($filter == 'all' || $filter == 'users')
                    <h3>Users</h3>
                    @if ($users->isEmpty())
                        <p>No users found.</p>
                    @else
                        <ul id="users">
                            @foreach ($users as $user)
                                <li>
                                    <a href="{{ route('userProfile', $user->user_id) }}">{{ $user->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                @endif
            </div>
        </div>
    </div>

    @endsection