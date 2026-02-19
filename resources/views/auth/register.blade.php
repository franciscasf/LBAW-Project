@extends('layouts.app')

@section('content')
<link href="{{ url('css/register.css') }}" rel="stylesheet">
<form id="aa" method="POST" action="{{ route('register') }}">

    {{ csrf_field() }}

    <label for="name">Username</label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
    @error('name')
        <span class="error text-danger">{{ $message }}</span>
    @enderror

    <label for="email">E-Mail Address</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
    @error('email')
        <span class="error text-danger">{{ $message }}</span>
    @enderror

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>
    @error('password')
        <span class="error text-danger">{{ $message }}</span>
    @enderror

    <label for="password-confirm">Confirm Password</label>
    <input id="password-confirm" type="password" name="password_confirmation" required>
    @error('password_confirmation')
        <span class="error text-danger">{{ $message }}</span>
    @enderror
    
    <button type="submit" id="aaa" class="submit-button">
        Register
    </button>

    <button type="submit" id="aaa" class="submit-button" onclick="window.location.href='{{ route('login') }}'">
        Login
    </button>

</form>


@endsection