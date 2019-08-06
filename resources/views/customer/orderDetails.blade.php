@extends('layouts.customer')

@section('content')
    <customer-order-details :id="{{ $order->id }}"></customer-order-details>
@endsection