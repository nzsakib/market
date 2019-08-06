@extends('layouts.customer')

@section('content')
    <customer-order-details :id="{{ $orderId }}"></customer-order-details>
@endsection