@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4 offset-md-4">
                <h3 class="text-center">Login to dashboard</h3>
                @include('partials.error')
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <button class="btn btn-primary" type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
@endsection