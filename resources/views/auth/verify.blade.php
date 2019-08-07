@extends('layout')

@section('content')
<div class="container">
    <div class="text-center alert alert-info">
        <h2>Verification email is sent to your email. please check inbox.</h2>
    </div>
    <div class="text-center">
        <a href="{{ route('verification.resend') }}">Click here to resend email</a>
    </div>
</div>
@endsection