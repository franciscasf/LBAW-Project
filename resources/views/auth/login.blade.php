@extends('layouts.app')

@section('content')
<link href="{{ url('css/login.css') }}" rel="stylesheet">

<div id="content" class="login-container">
    <div class="form-section">
        <script src="{{ url('js/login-transiction.js') }}"></script>
        <form id="login-form" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <label for="email" class="form-label">E-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-input">
            @if ($errors->has('email'))
                <span class="error-message">
                    {{ $errors->first('email') }}
                </span>
            @endif

            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" required class="form-input">
            @if ($errors->has('password'))
                <span class="error-message">
                    {{ $errors->first('password') }}
                </span>
            @endif

            
            <label class="remember-me">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
            </label>

            <a href="{{ route('password.request') }}" class="small-link">Forgot your password?</a>
            
            <button type="submit" id="login-button" class="submit-button">
                Login
            </button>
            <button type="button" class="submit-button" id="to-register">
                Register
            </button>

            @if (session('success'))
                <p class="success-message">
                    {{ session('success') }}
                </p>
            @endif
        </form>
    </div>

    
</div>
@endsection
