@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <cart></cart>
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

            <a href="{{ route('cart.checkout') }}" class="btn btn-outline-primary btn-block mt-5">Checkout</a>
        </div>
    </div>
</div>
@endsection