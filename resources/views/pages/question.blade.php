@extends('layouts.app')

@section('content')

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <script src="{{ asset('js/confirm.js') }}"></script>
    <script src="{{ asset('js/followQuestion.js') }}"></script>
    <script src="{{ asset('js/voteQuestion.js') }}"></script>
    <script src="{{ asset('js/delete-answer-question.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
    <link href="{{ url('css/question.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<div class="question-container">
    <h1>{{ $question->title }}</h1>
    <p>{{ $question->content }}</p>
    <small>
        @if ($question->edited_date)
            Edited by
        @else
            Asked by
        @endif
        <a href="{{ route('userProfile', $question->author->user_id) }}">
            {{ $question->author->first_name }} {{ $question->author->last_name }}
        </a>
        {{ $question->edited_date ? \Carbon\Carbon::parse($question->edited_date)->format('M d, Y') : \Carbon\Carbon::parse($question->created_date)->format('M d, Y') }}
    </small>

    <!-- Exibir Tags -->
    @if ($question->tags->isNotEmpty())
        <div class="tags">
            <h3>Tags:</h3>
            <ul>
                @foreach ($question->tags as $tag)
                    <li>
                        <span class="tag">
                            {{ $tag->acronym }} - {{ $tag->full_name }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    @auth
        <div id="follow-question-container-{{ $question->question_id }}">
            @if (auth()->user()->followedQuestions->contains($question->question_id))
                <button class="btn btn-danger follow-btn" data-question-id="{{ $question->question_id }}">
                    Unfollow
                </button>
            @else
                <button class="btn btn-primary follow-btn" data-question-id="{{ $question->question_id }}">
                    Follow
                </button>
            @endif
        </div>
    @endauth
    @auth
        <div class="vote-buttons mr-3">
            <button class="btn btn-success vote-btn" data-vote="1" data-question-id="{{ $question->question_id }}">
                <i class="fas fa-thumbs-up"></i> <span
                    id="upvotes-{{ $question->question_id }}">{{ $question->upvotesCount() }}</span>
            </button>

            <button class="btn btn-danger vote-btn" data-vote="0" data-question-id="{{ $question->question_id }}">
                <i class="fas fa-thumbs-down"></i> <span
                    id="downvotes-{{ $question->question_id }}">{{ $question->downvotesCount() }}</span>
            </button>
        </div>
    @endauth
    <hr>
    <div class="answers">
        <h2>Answers ({{ $question->answers->count() }})</h2>

        @if ($question->answers->isEmpty())
            <p>No answers yet. Be the first to answer!</p>
        @else
            @foreach ($question->answers as $answer)

                <div id="container-answer-aa">
                    <div id="likes-div">
                        <button class="btn btn-success btn-sm answer-vote-btn" data-answer-id="{{ $answer->answer_id }}"
                            data-vote-type="1" id="like-answers">
                            <i class="fas fa-thumbs-up"></i>
                            <span id="upvotes-answer-{{ $answer->answer_id }}">{{ $answer->upvotesCount() }}</span>
                        </button>

                        <button class="btn btn-danger btn-sm answer-vote-btn" data-answer-id="{{ $answer->answer_id }}"
                            data-vote-type="0" id="dislike-answers">
                            <i class="fas fa-thumbs-down"></i>
                            <span id="downvotes-answer-{{ $answer->answer_id }}">{{ $answer->downvotesCount() }}</span>
                        </button>

                    </div>

                    <div class="vote-buttons mr-3" id="restaaa">
                        @if($answer->isVerified())
                            <span class="badge badge-success">Verified <i class="fa-solid fa-check"></i></span>
                        @endif

                        <p>{{ $answer->content }}</p>

                        @if((auth()->check() && (auth()->user()->isVerified())) && !$answer->isVerified())
                            <form action="{{ route('answers.verify', $answer->answer_id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            </form>
                        @endif

                        <small>
                            @if ($answer->edited_date)
                                Edited by
                            @else
                                Posted by
                            @endif
                            <a href="{{ route('userProfile', parameters: $answer->author->user_id) }}">
                                {{ $answer->author->first_name }} {{ $answer->author->last_name }}
                            </a>
                            on
                            {{ $answer->created_date ? \Carbon\Carbon::parse($answer->created_date)->format('M d, Y') : 'Date not available' }}
                        </small>

                        @auth
                            @if(auth()->id() == $answer->author->user_id && !$answer->isVerified())
                                <form action="{{ route('answers.edit', $answer->answer_id) }}" method="GET" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning" id="edit-answer">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </form>

                            @endif
                            @if((auth()->id() == $answer->author->user_id && !$answer->isVerified()) || (auth()->user()->isModerator() || auth()->user()->isAdmin()))
                                <form action="{{ route('answers.delete', $answer->answer_id) }}" method="POST" style="display:inline;"
                                    class="delete-answer-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger delete-answer-btn"
                                        data-answer-id="{{ $answer->answer_id }}" id="delete_button_id">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            @endif
                        @endauth

                        <button id="aaaa" class="btn btn-info toggle-replies" data-answer-id="{{ $answer->answer_id }}">
                            <span class="toggle-icon"><i class="fa fa-chevron-down"></i></span>
                            <span class="reply-count">{{ $answer->getReplyCount() }} replies</span>
                        </button>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                document.querySelectorAll('.toggle-replies').forEach(button => {
                                    if (button.dataset.initialized) return;
                                    button.dataset.initialized = true;

                                    button.addEventListener('click', function () {
                                        const answerId = this.getAttribute('data-answer-id');
                                        const answerElement = this.closest('div');
                                        const icon = this.querySelector('.toggle-icon i');
                                        const replyCount = this.querySelector('.reply-count');

                                        if (!answerElement.classList.contains('loaded')) {
                                            fetch(`/answers/${answerId}/replies`)
                                                .then(response => response.json())
                                                .then(replies => {
                                                    if (replies.length > 0) {
                                                        replies.forEach(reply => {
                                                            if (!answerElement.querySelector(`[data-reply-id="${reply.answer_id}"]`)) {
                                                                const replyHtml = `
                                                                    <div class="reply" data-reply-id="${reply.answer_id}" style="margin-bottom: 10px;">
                                                                        <p>${reply.content || 'No content available'}</p>
                                                                        <small>
                                                                            Posted by 
                                                                            ${reply.author ? `
                                                                                <a href="/userProfile/${reply.author.user_id}">
                                                                                    ${reply.author.first_name || 'Unknown'} ${reply.author.last_name || ''}
                                                                                </a>` : 'Unknown Author'}
                                                                            on ${reply.created_date ? new Date(reply.created_date.replace(' ', 'T')).toLocaleDateString('en-US', {
                                                                    month: 'short', day: 'numeric', year: 'numeric'
                                                                }) : 'Date not available'}
                                                                        </small>
                                                                    </div>`;
                                                                answerElement.insertAdjacentHTML('beforeend', replyHtml);
                                                            }
                                                        });
                                                    } else {
                                                        if (!answerElement.querySelector('.no-replies-message')) {
                                                            answerElement.insertAdjacentHTML('beforeend', '<p class="no-replies-message">No replies yet.</p>');
                                                        }
                                                    }
                                                    if (!answerElement.querySelector('.reply-form')) {
                                                        const replyFormHtml = `
                                                            @auth
                                                                <form class="reply-form" data-answer-id="${answerId}" method="POST" action="{{ route('answers.reply', $answer->answer_id) }}">
                                                                    @csrf
                                                                    <textarea name="content" rows="4" placeholder="Write your reply..." required></textarea>
                                                                    <button type="submit">Submit Reply</button>
                                                                </form>
                                                                <p class="success-message" style="color: green; display: none;">Your reply has been posted!</p>
                                                            @else
                                                                <p>Please <a href="{{ route('login') }}">login</a> to add a reply.</p>
                                                            @endauth`;
                                                        answerElement.insertAdjacentHTML('beforeend', replyFormHtml);
                                                    }

                                                    answerElement.classList.add('loaded');
                                                    icon.classList.remove('fa-chevron-down');
                                                    icon.classList.add('fa-chevron-up');
                                                    replyCount.textContent = `${replies.length} replies`;
                                                    const replyForm = answerElement.querySelector('.reply-form');
                                                    if (replyForm) {
                                                        replyForm.addEventListener('submit', function (e) {
                                                            e.preventDefault(); // Prevent the page from reloading
                                                            handleReplyFormSubmit(replyForm, replyCount);
                                                        });
                                                    }
                                                })
                                                .catch(error => {
                                                    console.error('Error fetching replies:', error);
                                                    alert('Failed to load replies. Please try again.');
                                                });
                                        } else {
                                            toggleRepliesVisibility(answerElement, icon);
                                        }
                                    });
                                });

                                function toggleRepliesVisibility(answerElement, icon) {
                                    answerElement.querySelectorAll('.reply, .reply-form, .no-replies-message').forEach(el => {
                                        const currentDisplay = window.getComputedStyle(el).display;
                                        el.style.display = currentDisplay === 'none' ? '' : 'none';
                                    });

                                    if (icon.classList.contains('fa-chevron-down')) {
                                        icon.classList.remove('fa-chevron-down');
                                        icon.classList.add('fa-chevron-up');
                                    } else {
                                        icon.classList.remove('fa-chevron-up');
                                        icon.classList.add('fa-chevron-down');
                                    }
                                }

                                function handleReplyFormSubmit(form, replyCountElement) {
                                    const answerId = form.getAttribute('data-answer-id');
                                    const formData = new FormData(form);

                                    fetch(form.action, {
                                        method: 'POST',
                                        body: formData,
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest'
                                        }
                                    })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                const replyHtml = `
                                                    <div class="reply" data-reply-id="${data.reply.answer_id}" style="margin-bottom: 10px;">
                                                        <p>${data.reply.content || 'No content available'}</p>
                                                        <small>
                                                            Posted by 
                                                            ${data.reply.author ? `
                                                                <a href="/userProfile/${data.reply.author.user_id}">
                                                                    ${data.reply.author.first_name || 'Unknown'} ${data.reply.author.last_name || ''}
                                                                </a>` : 'Unknown Author'}
                                                            on ${data.reply.created_date ? new Date(data.reply.created_date.replace(' ', 'T')).toLocaleDateString('en-US', {
                                                    month: 'short', day: 'numeric', year: 'numeric'
                                                }) : 'Date not available'}
                                                        </small>
                                                    </div>`;
                                                form.insertAdjacentHTML('beforebegin', replyHtml);
                                                form.reset(); // Clear the form
                                                form.nextElementSibling.style.display = 'block';

                                                const currentCount = parseInt(replyCountElement.textContent) || 0;
                                                replyCountElement.textContent = `${currentCount + 1} replies`;
                                            } else {
                                                alert('Failed to post reply. Please try again.');
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error submitting reply:', error);
                                            alert('Failed to post reply. Please try again.');
                                        });
                                }
                            });
                        </script>
                    </div>

                </div>
            @endforeach
        @endif

        <div class="add-answer">
            @auth
                <form method="POST" action="{{ url('/questions/' . $question->question_id) }}">
                    @csrf
                    <input type="hidden" name="question_id" value="{{ $question->question_id }}">
                    <textarea name="content" rows="4" placeholder="Write your answer..." required></textarea>
                    <button type="submit">Submit Answer</button>
                </form>

                <p id="success-message" style="color: green; display: none;">Your answer has been posted!</p>
            @else
                <p>Please <a href="{{ route('login') }}">login</a> to add an answer.</p>
            @endauth
        </div>

        @auth
            @if ($question->author_id === auth()->user()->user_id || auth()->user()->isModerator() || auth()->user()->isAdmin())
                <form action="{{ route('questions.edit', $question->question_id) }}" method="GET" style="display: inline;">
                    <button type="submit" id="lower-b" class="btn btn-warning">
                        Edit Question
                    </button>
                </form>

                <button class="btn btn-danger" id="lower-b" type="button" onclick="event.preventDefault(); openModal()">
                    Delete Question
                </button>
                <form action="{{ route('questions.delete', $question->question_id) }}" method="POST" id="lower-a"
                    style="display: none;" id="deleteForm">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        @endauth
    </div>

    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h2>Are you sure?</h2>
            <p>Are you sure you want to delete this question? This action cannot be undone.</p>
            <div class="modal-actions">
                <button onclick="closeModal()" class="btn btn-secondary">Cancel</button>
                <button onclick="confirmDelete()" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
    @endsection