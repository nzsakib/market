@extends('layout')

@section('content')
    <div class="container">
        <div class="product-details row">
            <div class="col-4">
                @include('product.partials.slider')
            </div>
            <div class="col-8">
                <h1 class="product-details__title">{{ $product->title }}</h1>
                <p class="product-details__description">
                    {{ $product->description }}
                </p>

                <div class="product-details__price">
                    Tk {{ $product->price }}
                </div>

                <div class="product-details__quantity">
                    Available Quantity: {{ $product->quantity }}
                </div>

                <div class="product-details__cta">
                    <form action="/cart" method="POST">
                        @csrf 
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-sm btn-primary">Add to cart</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection