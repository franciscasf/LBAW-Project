@extends('layouts.app')

@section('content')
<style>
    /* General Styling */
    body {
        background-color: #f4f7fb;
        margin: 0;
        padding: 0;
    }

    .suggestions-container {
        max-width: 900px;
        margin: 50px auto;
        padding: 40px;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: box-shadow 0.3s ease-in-out;
    }

    .suggestions-container:hover {
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
    }

    .suggestions-header h1 {
        font-size: 3rem;
        color: #9d1b1b;
        text-align: center;
        margin-bottom: 30px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .suggestions-intro {
        font-size: 1.6rem;
        color: #555;
        text-align: center;
        margin-bottom: 40px;
        font-weight: 300;
    }

    .suggestions-form {
        display: flex;
        flex-direction: column;
    }

    .suggestions-form textarea {
        font-size: 1.4rem;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
        border: 1px solid #ddd;
        resize: vertical;
        min-height: 200px;
        color: #555;
        background-color: #f9f9f9;
        transition: border-color 0.3s ease-in-out;
    }

    .suggestions-form textarea:focus {
        outline: none;
        border-color: #9d1b1b;
    }

    .suggestions-form button {
        font-size: 1.4rem;
        padding: 12px 30px;
        background-color: #9d1b1b;
        color: #fff;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;

        /* Center the button content */
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .suggestions-form button:hover {
        background-color: #800000;
    }

    .suggestions-form p {
        text-align: center;
        font-size: 1.2rem;
        color: #555;
        margin-top: 20px;
    }

    .suggestions-form p a {
        color: #9d1b1b;
        text-decoration: none;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .suggestions-container {
            padding: 20px;
        }

        .suggestions-header h1 {
            font-size: 2.5rem;
        }

        .suggestions-intro {
            font-size: 1.4rem;
        }

        .suggestions-form button {
            font-size: 1.2rem;
        }
    }
</style>

<div class="suggestions-container">
    <div class="suggestions-header">
        <h1>Submit Your Suggestions</h1>
    </div>
    <p class="suggestions-intro">
        Have an idea or feedback on how we can make your experience better? Share your thoughts with us by filling out the form below.
    </p>
    <form class="suggestions-form" method="POST" action="{{ route('suggestions.store') }}">
        @csrf
        <label for="suggestion">Your Suggestion:</label>
        <textarea id="suggestion" name="suggestion" placeholder="Write your suggestion here..." required></textarea>

        <button type="submit">Submit Suggestion</button>
    </form>
    <p class="suggestions-intro">
        Your input is valuable to us and helps shape the future of AskLEIC. If you’d like to share other feedback or inquiries, feel free to email us at <strong><a href="mailto:contact@askleic.com">contact@askleic.com</a></strong>.
    </p>
</div>
@endsection
