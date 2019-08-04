@extends('layout')

@section('content')
    <div class="container">
        <h1 class="text-center">Register as Customer</h1>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
        <form action="/register" method="POST">
            @csrf 
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="form-group">
                <label for="password">Password Confirmation</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <button class="btn btn-primary btn-block" type="submit">Register</button>
        </form>
    </div>
@endsection