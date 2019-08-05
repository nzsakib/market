@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
            <h3>Shipping Address</h3>
            @include('partials.error')
            <hr>
            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="phone">Mobile</label>
                    <input type="text" name="phone" value="{{ auth()->user()->phone }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea name="address" id="address" cols="30" rows="5" class="form-control">{{ auth()->user()->address }}</textarea>
                </div>

                <div class="form-group">
                    <button class="btn btn-outline-primary" type="submit">Place Order</button>
                </div>
            </form>

        </div>
        <div class="col-4">
            <h3>Checkout Summery</h3>
            <hr>
            <div class="row">
                <div class="col">
                    Total
                </div>
                <div class="col">
                    {{ $total }} Tk
                </div>
            </div>

            
        </div>
    </div>
</div>
@endsection