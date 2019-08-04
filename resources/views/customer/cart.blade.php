@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
            @if(isset($items))
            @foreach ($items as $item)
            <div class="row">
                <div class="col-3">
                    <img src="https://placeimg.com/200/200/arch" alt="" class="img-fluid">
                </div>
                <div class="col-6">
                    <h5>{{ $item->product->title }}</h5>
                    <p>Shop name here</p>
                    <form action="/cart/update" method="POST" class="form-inline">
                        <input type="hidden" name="cart_item" value="">
                        <label for="" class="mr-1">Qty: </label>
                        <input type="number" name="quantity" class="col-2 form-control mr-2" value="{{ $item->quantity }}">
                        <button class="btn btn-sm btn-info">Update</button>
                    </form>
                </div>
                <div class="col-3">
                    {{ $item->product->price }} Tk
                </div>
            </div>
            @endforeach
            @else
            <h1>No cart</h1>

            @endif

        </div>
        <div class="col-4">
            <h3>Checkout Summery</h3>
            <hr>

        </div>
    </div>
</div>
@endsection