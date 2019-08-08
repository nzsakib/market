@extends('layouts.vendor')

@section('content')
    <h3>Product Details</h3>
    <hr>
    <vendor-add-product productid="{{ $productId }}"></vendor-add-product>
@endsection