@extends('layout')

@section('content')
    <div class="container">
        <div class="error">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
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