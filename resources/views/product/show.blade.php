@extends('layout')

@section('content')
    <div class="container">
        <div class="product-details">
            <h1 class="product-details__title">{{ $product->title }}</h1>
            <p>
                {{ $product->description }}
            </p>
        </div>
    </div>
@endsection