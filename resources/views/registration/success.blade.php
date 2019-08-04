@extends('layout')

@section('content')
    <div class="container">
        <div class="text-center alert alert-success">
            <h3>Your email was verified successfully. You can now login</h3>
        </div>

        <div class="text-center">
            <a href="/login" class="btn btn-primary">Login</a>
        </div>
    </div>
@endsection