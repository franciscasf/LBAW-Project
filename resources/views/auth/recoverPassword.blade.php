@extends('layouts.app')

@section('content')
<link href="{{ url('css/login.css') }}" rel="stylesheet">

<div id="content" class="login-container">
    <div class="form-section">
        <script src="{{ url('js/login-transiction.js') }}"></script>
        <form id="reset-password-form" method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="container">
                <h2>Reset Password</h2>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" required
                        placeholder="Enter your email">
                </div>

                <button type="submit" class="submit-button">
                    Send Verification Email
                </button>
            </div>
        </form>

        @if (session('status'))
            <p class="success-message" style="color: green;">
                {{ session('status') }}
            </p>
        @endif


        @if ($errors->has('email'))
            <p class="error-message" style="color: red;">
                {{ $errors->first('email') }}
            </p>
        @endif
    </div>
</div>



</div>
@endsection