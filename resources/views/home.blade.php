@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        @foreach ($products as $product)
        <div class="col-3 product">
            <img src="{{ $product->image }}" alt="{{ $product->title }}" class="product__thumbnail img-fluid">
            <a href="{{ route('product.details', $product) }}">
                <h1 class="product__title">{{ $product->title }}</h1>
            </a>
            <div class="row">
                <div class="col-4 product__price">
                    BDT {{ $product->price }}
                </div>

                <div class="col-8 text-right">
                    <a href="#" class="btn btn-sm btn-primary">Add to cart</a>
                </div>
            </div>
        </div>     
        @endforeach
    </div>
</div>
@endsection