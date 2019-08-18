@extends('layout')

@section('content')
<div class="container">
    @include('partials.message')
    <div class="row">
        @foreach ($products as $product)
        <div class="col-3 product">
            <img src="/storage/{{ optional($product->images->first())->image_path }}" alt="{{ $product->title }}" class="product__thumbnail img-fluid">
            <a href="{{ route('product.details', $product) }}">
                <h1 class="product__title">{{ $product->title }}</h1>
            </a>
            <div class="row">
                <div class="col-4 product__price">
                    BDT {{ $product->price }}
                </div>

                <div class="col-8 text-right">
                    <form action="/cart" method="POST">
                        @csrf 
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-sm btn-primary">Add to cart</button>
                    </form>
                </div>
            </div>
        </div>     
        @endforeach
    </div>
    {{ $products->links() }}
</div>
@endsection