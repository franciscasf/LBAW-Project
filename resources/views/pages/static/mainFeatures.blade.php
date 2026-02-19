@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="text-center mb-5">
        <h1 class="display-4 font-weight-bold">Main Features</h1>
        <p class="lead text-muted">Explore all the tools that make AskLEIC the ultimate academic forum for LEIC students.</p>
    </div>

    <h2 class="mb-4 font-weight-bold">For All Users</h2>
    <div class="row text-center">
        <!-- Feature: Academic Forum -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-comments fa-3x text-primary mb-3"></i>
                    <h4 class="card-title">Academic Forum</h4>
                    <p class="card-text">Ask questions, browse posts, and collaborate with fellow LEIC students.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-search fa-3x text-success mb-3"></i>
                    <h4 class="card-title">Advanced Search</h4>
                    <p class="card-text">Search questions and answers using full-text search, exact matches, or filters.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-tags fa-3x text-danger mb-3"></i>
                    <h4 class="card-title">Tag System</h4>
                    <p class="card-text">Easily browse questions by tags and filter results for precise answers.</p>
                </div>
            </div>
        </div>
    </div>
    <h2 class="mt-5 mb-4 font-weight-bold">For Authenticated Users</h2>
    <div class="row text-center">
        <!-- Feature: Post Questions -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-question-circle fa-3x text-primary mb-3"></i>
                    <h4 class="card-title">Post Questions</h4>
                    <p class="card-text">Post questions about tags of interest and receive help from the community.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-star fa-3x text-warning mb-3"></i>
                    <h4 class="card-title">Follow Tags & Questions</h4>
                    <p class="card-text">Follow specific tags and questions to receive updates and personalized content.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-rss fa-3x text-info mb-3"></i>
                    <h4 class="card-title">Personalized Feed</h4>
                    <p class="card-text">Access a personalized feed with updates on tags, questions, and answers you follow.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-medal fa-3x text-success mb-3"></i>
                    <h4 class="card-title">Receive Badges</h4>
                    <p class="card-text">Earn badges based on your contributions to the community.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-bell fa-3x text-primary mb-3"></i>
                    <h4 class="card-title">Notifications</h4>
                    <p class="card-text">Get notified about updates on followed or posted questions and answers.</p>
                </div>
            </div>
        </div>
    </div>
    <h2 class="mt-5 mb-4 font-weight-bold">For Administrators</h2>
    <div class="row text-center">
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-users-cog fa-3x text-primary mb-3"></i>
                    <h4 class="card-title">User Management</h4>
                    <p class="card-text">Create, edit, block, unblock, or delete user accounts to maintain platform order.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-tags fa-3x text-danger mb-3"></i>
                    <h4 class="card-title">Manage Tags</h4>
                    <p class="card-text">Create, update, or remove tags to keep discussions organized and relevant.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-award fa-3x text-warning mb-3"></i>
                    <h4 class="card-title">Manage Badges</h4>
                    <p class="card-text">Create, edit, or remove badges to recognize user contributions.</p>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mt-5 mb-4 font-weight-bold">For Moderators</h2>
    <div class="row text-center">
        <!-- Feature: Delete Posts -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-trash fa-3x text-danger mb-3"></i>
                    <h4 class="card-title">Delete Posts</h4>
                    <p class="card-text">Remove inappropriate or irrelevant posts to maintain a healthy community.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-edit fa-3x text-info mb-3"></i>
                    <h4 class="card-title">Edit Question Tags</h4>
                    <p class="card-text">Ensure questions are correctly tagged for better searchability and organization.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center mt-5">
        <h2>Join AskLEIC Today!</h2>
        <p class="lead">Collaborate, ask questions, and contribute to a better academic experience for everyone.</p>
    </div>
</div>
@endsection
