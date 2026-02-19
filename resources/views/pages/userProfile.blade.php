@extends('layouts.app')
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

@section('content')

<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<script src="{{ asset('js/delete-answer.js') }}"></script>
<div class="user-profile-container">
    <h1 class="profile-title">{{ $title }}</h1>
    <div class="container-box">
        <h2>
            @if(auth()->id() == $user->user_id)
                My Info
            @else
                {{ $user->first_name }} {{ $user->last_name }}'s Info
            @endif
        </h2>
        @if($user)
        <div class="profile-container">
            <div class="profile-pic">
                <img class="actual-image" src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture">
            </div>
            <div id="info-user">
                <p>
                    <strong>Name:</strong> {{ $user->first_name ?? 'N/A' }} {{ $user->last_name ?? 'N/A' }}
                    @if($user->isVerified())  
                        <i class="fas fa-check-circle" style="color: 8C0000;"></i>
                    @endif
                </p>
                <p>
                    <strong>Username:</strong> {{ $user->name ?? 'N/A' }}
                </p>
                <p><strong>Email:</strong> {{ $user->email ?? 'N/A' }}</p>
                
                @php
                    $verifiedUser = $user->verifiedUser; 
                @endphp

                @if($verifiedUser && $verifiedUser->status !== null && $verifiedUser->status == true)
                    <p><strong>Degree:</strong> {{ $verifiedUser->degree ?? 'N/A' }}</p>
                    <p><strong>School:</strong> {{ $verifiedUser->school ?? 'N/A' }}</p>
                @endif
                <p><strong>Description:</strong> {{ $user->description ?? 'Hi! No description yet.' }}</p>
            </div>  
        </div>

                @if(auth()->id() == $user->user_id)

                <button type="button" class="btn btn-primary open-modal" data-modal-id="changeImageModal">
                    Change Image
                </button>
                <div class="modal" id="changeImageModal" tabindex="-1" aria-labelledby="changeImageModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="changeImageModalLabel">Change Profile Picture</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('user.updateProfilePicture') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <label for="profile_picture">Select a new profile picture:</label>
                                    <input type="file" name="profile_picture" id="profile_picture" required>
                                    <button type="submit" class="btn btn-success mt-3" style="background-color:8C0000 ;">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script src="{{ asset('js/change-img.js') }}"></script>

                <div class="modal" id="changeImageModal" tabindex="-1" role="dialog" aria-labelledby="changeImageModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="changeImageModalLabel">Change Profile Picture</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('user.updateProfilePicture') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <label for="profile_picture">Select a new profile picture:</label>
                                            <input type="file" name="profile_picture" id="profile_picture" required>
                                            <button type="submit" class="btn btn-success mt-3">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editProfileModal">
                        Edit Profile / Change Password
                    </button>

                    <!-- Modal Structure -->
                    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editProfileModalTitle">Edit Profile / Change Password</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Edit Profile Form -->
                                    <form method="POST" action="{{ route('user.update', ['id' => $user->user_id]) }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group">
                                            <label for="first_name">
                                                First Name
                                                <span class="contextual-help" data-toggle="tooltip" title="Your first name, e.g., John.">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                            </label>
                                            <input 
                                                type="text" 
                                                class="form-control @error('first_name') is-invalid @enderror" 
                                                id="first_name" 
                                                name="first_name" 
                                                value="{{ old('first_name', $user->first_name) }}" 
                                                required>
                                            @error('first_name')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="last_name">
                                                Last Name
                                                <span class="contextual-help" data-toggle="tooltip" title="Your last name, e.g., Doe.">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                            </label>
                                            <input 
                                                type="text" 
                                                class="form-control @error('last_name') is-invalid @enderror" 
                                                id="last_name" 
                                                name="last_name" 
                                                value="{{ old('last_name', $user->last_name) }}" 
                                                required>
                                            @error('last_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="name">
                                                Username
                                                <span class="contextual-help" data-toggle="tooltip" title="This will be your unique display name.">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                            </label>
                                            <input 
                                                type="text" 
                                                class="form-control @error('name') is-invalid @enderror" 
                                                id="name" 
                                                name="name" 
                                                value="{{ old('name', $user->name) }}" 
                                                required>
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="email">
                                                Email
                                                <span class="contextual-help" data-toggle="tooltip" title="Your valid email address.">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                            </label>
                                            <input 
                                                type="email" 
                                                class="form-control @error('email') is-invalid @enderror" 
                                                id="email" 
                                                name="email" 
                                                value="{{ old('email', $user->email) }}" 
                                                required>
                                                @error('email')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror

                                        </div>

                                        <div class="form-group">
                                            <label for="description">
                                                Description
                                                <span class="contextual-help" data-toggle="tooltip" title="Tell us a bit about yourself. Max 150 characters.">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                            </label>
                                            <textarea 
                                                class="form-control @error('description') is-invalid @enderror" 
                                                id="description" 
                                                name="description" 
                                                rows="4">{{ old('description', $user->description) }}</textarea>
                                                @error('description')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror

                                        </div>

                                        <button type="submit" class="btn btn-success">Save Profile</button>
                                    </form>

                                    <hr>

                                    <form method="POST" action="{{ route('password.update', ['id' => $user->user_id]) }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group">
                                            <label for="current_password">Current Password</label>
                                            <input 
                                                type="password" 
                                                class="form-control @error('current_password') is-invalid @enderror" 
                                                id="current_password" 
                                                name="current_password" 
                                                required>
                                            @error('current_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="new_password">New Password</label>
                                            <input 
                                                type="password" 
                                                class="form-control @error('new_password') is-invalid @enderror" 
                                                id="new_password" 
                                                name="new_password" 
                                                required>
                                            @error('new_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="new_password_confirmation">Confirm New Password</label>
                                            <input 
                                                type="password" 
                                                class="form-control" 
                                                id="new_password_confirmation" 
                                                name="new_password_confirmation" 
                                                required>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteAccoutModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccoutModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteAccoutModalLabel">Delete Account</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete your account?
                                    Once deleted, it cannot be recovered!
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <form action="{{ route('users.destroy', $user->user_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                                @endif
                        @else
                            <p>User data not found.</p>
                        @endif
                </div>

                @if(auth()->id() == $user->user_id)
                <div class="container-box">
                    <h2>
                            Followed Tags
                            <span class="contextual-help" data-toggle="tooltip" title="Here are the tags you're currently following. Click on the plus to add more tags or to edit your choices.">
                            <i class="fas fa-info-circle"></i>
                        </span>
                    </h2>

                    @forelse ($user->followedTags as $tag)
                        <div class="tag-item">
                            <p class="tag-name"><strong>{{ $tag->full_name }}</strong> ({{ $tag->acronym }})</p>
                        </div>
                        <hr>
                    @empty
                        <p>You're not currently following any tags!</p>
                    @endforelse

                    @if(auth()->id() == $user->user_id)
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTagModal">
                            +
                        </button>
                    @endif
                </div>
                @endif
                <div class="modal fade" id="addTagModal" tabindex="-1" role="dialog" aria-labelledby="addTagModalTitle"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addTagModalTitle">Add New Tags</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('user.addTags', ['id' => $user->user_id]) }}">
                                @csrf
                                <div class="modal-body">
                                    <p>Select tags you want to follow:</p>
                                    <div class="form-group">
                                        @foreach ($tags as $tag)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->tag_id }}"
                                                    id="tag{{ $tag->tag_id }}" {{ $user->followedTags->contains($tag) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="tag{{ $tag->tag_id }}">
                                                    {{ $tag->full_name }} ({{ $tag->acronym }})
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @if(auth()->id() == $user->user_id)
                <div class="container-box">
                    <h2>
                            Followed Questions
                            <span class="contextual-help" data-toggle="tooltip" title="Here are your following questions. To follow a question, open it and click 'Follow Question'. To unfollow, open it and click 'Unfollow'. You'll be notified when new answers are added.">
                            <i class="fas fa-info-circle"></i>
                        </span>
                    </h2>

                    @forelse ($user->followedQuestions as $question)
                        <div class="question-item">
                            <a href="{{ url('/questions/' . $question->question_id) }}" class="question-link">
                                <h3 class="question-title">{{ $question->title }}</h3>
                            </a>
                            <p class="question-snippet">
                                {{ Str::limit($question->content, 100) }}
                            </p>
                            <small class="question-meta">
                                Posted by 
                                <a href="{{ route('userProfile', $question->author->user_id) }}">
                                    {{ $question->author->first_name }} {{ $question->author->last_name }}
                                </a>
                                on {{ \Carbon\Carbon::parse($question->created_date)->format('M d, Y') }}
                            </small>
                        </div>
                        <hr>
                    @empty
                        <p>
                            @if(auth()->id() == $user->user_id)
                                You are not following any questions.
                            @else
                                {{ $user->first_name }} {{ $user->last_name }} is not following any questions.
                            @endif
                        </p>
                    @endforelse
                </div>
                @endif

                <div class="container-box">
                    <h2>
                        @if(auth()->id() == $user->user_id)
                            My Badges
                            <span class="contextual-help" data-toggle="tooltip" title="This section shows your accomplishments. Keep interacting within the app, posting, and you will achieve new badges!">
                                <i class="fas fa-info-circle"></i>
                            </span>
                        @else
                            {{ $user->first_name }} {{ $user->last_name }}'s Badges
                        @endif
                    </h2>

                    @if($user->badges->isNotEmpty())
                        <ul class="badge-list">
                            @foreach($user->badges as $badge)
                                <li class="badge-item">
                                    <i class="fas fa-award" style="color: gold;"></i>
                                    <strong>{{ $badge->name }}</strong>: {{ $badge->description }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>
                            @if(auth()->id() == $user->user_id)
                                You have not earned any badges yet.
                            @else
                                {{ $user->first_name }} {{ $user->last_name }} has not earned any badges yet.
                            @endif
                        </p>
                    @endif
                </div>
                <div class="container-box">
                    <h2>
                        @if(auth()->id() == $user->user_id)
                            My Questions
                            <span class="contextual-help" data-toggle="tooltip" title="These are all your posted questions.">
                                <i class="fas fa-info-circle"></i>
                            </span>
                        @else
                            {{ $user->first_name }} {{ $user->last_name }}'s Questions
                        @endif
                    </h2>

                    @forelse ($user->questions as $question)
                        <div class="question-item">
                            <a href="{{ url('/questions/' . $question->question_id) }}" class="question-link">
                                <h3 class="question-title">{{ $question->title }}</h3>
                            </a>
                            <p class="question-snippet">
                                {{ $question->content ? Str::limit($question->content, 100) : 'No content available.' }}
                            </p>
                            <small class="question-meta">
                                Posted on {{ $question->created_date }}
                            </small>
                        </div>
                        <hr>
                    @empty
                        <p>You haven't posted any questions yet.</p>
                    @endforelse
                </div>
                <div class="container-box">
                    <h2>
                        @if(auth()->id() == $user->user_id)
                            My Answers
                            <span class="contextual-help" data-toggle="tooltip" title="These are all your answers.">
                                <i class="fas fa-info-circle"></i>
                            </span>
                        @else
                            {{ $user->first_name }} {{ $user->last_name }}'s Answers
                        @endif
                    </h2>
                    @forelse ($user->answers->reverse() as $answer)
                        <div class="answer-item">
                            <p class="answer-content">
                            @if(is_null($answer->getQuestionId()))
                                <span class="error-message">Reply's answer deleted</span>
                            @else
                                <a href="{{ url('/questions/' . $answer->getQuestionId()) }}" class="answer-link">
                                    {{ Str::limit($answer->content, 100) }}
                                </a>
                            @endif
                            </p>
                            <small class="answer-meta">
                                Posted by
                                {{ $answer->author->name }}
                                on
                                {{ $answer->created_date ? \Carbon\Carbon::parse($answer->created_date)->format('M d, Y') : 'Date not available' }}
                            </small>
                            @if((auth()->id() == $answer->author->user_id && !$answer->isVerified()) || (auth()->user()->isModerator() || auth()->user()->isAdmin()))
                                <button id="delete_button_id" data-answer-id="{{ $answer->answer_id }}" class="btn btn-danger delete-answer-btn">
                                    <i class="fas fa-trash"></i>
                                </button>
                            @endif
                        </div>
                        <hr>
                    @empty
                        <p id="empty-message" style="display:none;">You haven't posted any answers yet.</p>
                        <p>You haven't posted any answers yet.</p>
                    @endforelse
                </div>


                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteAccoutModal">
                        Delete Account
                    </button>
                @if((auth()->check() && (!auth()->user()->isVerified())) && auth()->id() == $user->user_id )
                    <button type="button" class="btn btn-primary {{ auth()->user()->isVerificationPending() ? 'pending' : '' }}"
                        data-toggle="modal" data-target="#verificationModal" {{ auth()->user()->isVerificationPending() ? 'disabled' : '' }}>

                        @if(auth()->user()->isVerificationPending())
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Pending Review
                        @else
                            Apply for Verification
                        @endif

                    </button>
                @endif
                <div class="modal fade" id="verificationModal" tabindex="-1" role="dialog" aria-labelledby="verificationModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verificationModalLabel">Apply for Verification</h5>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('user.applyForVerification') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                    <label for="degree">
                                        Degree:
                                        <span class="contextual-help" data-toggle="tooltip" title="Enter your degree, e.g., Bachelor of Science in Computer Science.">
                                            <i class="fas fa-info-circle"></i>
                                        </span>
                                    </label>
                                        <input type="text" class="form-control" name="degree" id="degree"
                                            placeholder="e.g., Bachelor of Science in Computer Science" required>
                                    </div>

                                    <div class="form-group">
                                    <label for="school">
                                            School:
                                            <span class="contextual-help" data-toggle="tooltip" title="Enter the name of your school or institution, e.g., Porto University.">
                                                <i class="fas fa-info-circle"></i>
                                            </span>
                                    </label>
                                        <input type="text" class="form-control" name="school" id="school"
                                            placeholder="e.g., Porto University" required>
                                    </div>

                                    <div class="form-group">
                                    <label for="id_picture">
                                            Upload ID (proof of teaching):
                                            <span class="contextual-help" data-toggle="tooltip" title="Upload a valid proof of teaching, such as a teaching card, university ID, or similar document.">
                                                <i class="fas fa-info-circle"></i>
                                            </span>
                                    </label>
                                        <input type="file" class="form-control-file" name="id_picture" id="id_picture" required>
                                    </div>

                                    <button type="submit" class="btn btn-success mt-3">Submit Application</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const tooltips = document.querySelectorAll('[data-toggle="tooltip"]');
                        tooltips.forEach(tooltip => {
                            tooltip.addEventListener('mouseover', function () {
                                const title = this.getAttribute('title');
                                if (title) {
                                    const tooltipElement = document.createElement('div');
                                    tooltipElement.className = 'custom-tooltip';
                                    tooltipElement.textContent = title;

                                    document.body.appendChild(tooltipElement);

                                    const rect = this.getBoundingClientRect();
                                    tooltipElement.style.left = rect.left + window.scrollX + 'px';
                                    tooltipElement.style.top = rect.top + window.scrollY - tooltipElement.offsetHeight - 5 + 'px';
                                }
                            });

                            tooltip.addEventListener('mouseout', function () {
                                document.querySelectorAll('.custom-tooltip').forEach(tooltipEl => tooltipEl.remove());
                            });
                        });

                        const openModalButtons = document.querySelectorAll('.open-modal, [data-toggle="modal"]');
                        const closeModalButtons = document.querySelectorAll('[data-dismiss="modal"]');
                        const modals = document.querySelectorAll('.modal');

                        openModalButtons.forEach(button => {
                            button.addEventListener('click', function () {
                                const modalId = this.getAttribute('data-target') || this.getAttribute('data-modal-id');
                                const modal = document.querySelector(modalId);
                                if (modal) {
                                    modal.style.display = 'block';
                                    modal.setAttribute('aria-hidden', 'false'); 
                                    modal.classList.add('show'); 
                                    document.body.classList.add('modal-open');
                                }
                            });
                        });

                        closeModalButtons.forEach(button => {
                            button.addEventListener('click', function () {
                                const modal = this.closest('.modal');
                                if (modal) {
                                    modal.style.display = 'none';
                                    modal.setAttribute('aria-hidden', 'true'); 
                                    modal.classList.remove('show');
                                    document.body.classList.remove('modal-open');
                                }
                            });
                        });

                        window.addEventListener('click', event => {
                            modals.forEach(modal => {
                                if (event.target === modal) {
                                    modal.style.display = 'none';
                                    modal.setAttribute('aria-hidden', 'true');
                                    modal.classList.remove('show');
                                    document.body.classList.remove('modal-open');
                                }
                            });
                        });
                    });

//
                document.addEventListener('DOMContentLoaded', function () {
                        @if ($errors->any())
                            const modalId = '#editProfileModal';
                            const modal = document.querySelector(modalId);
                            if (modal) {
                                modal.style.display = 'block';
                                modal.setAttribute('aria-hidden', 'false');
                                modal.classList.add('show');
                                document.body.classList.add('modal-open');
                            }
                        @endif
                    });
        </script>



    @endsection