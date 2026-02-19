@extends('layouts.app')

@section('content')

<style>
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #8C0000; 
    font-size: 2em;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

label {
    font-size: 1.1em;
    color: #333;
    margin-bottom: 8px;
    display: block;
}

textarea.form-control {
    width: 100%;
    padding: 12px;
    border-radius: 5px;
    border: 1px solid #ccc;
    resize: vertical;
    font-size: 1em;
    transition: border-color 0.3s ease;
}

textarea.form-control:focus {
    border-color: #8C0000; 
    outline: none;
}

button.btn {
    background-color: #8C0000;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 5px;
    font-size: 1.1em;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%; 
}

button.btn:hover {
    background-color: #A70000; 
}

button.btn:focus {
    outline: none; 
}

</style>

    <div class="container">
        <h1>Edit Your Answer</h1>

        <form method="POST" action="{{ route('answers.update', $answer->answer_id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="content">Answer Content</label>
                <textarea name="content" id="content" rows="5" class="form-control" required>{{ old('content', $answer->content) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Answer</button>
        </form>
    </div>
@endsection
