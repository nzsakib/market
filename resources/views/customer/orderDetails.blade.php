@extends('layouts.customer')

@section('content')
    <div class="order-details">
        <h3>Order ID: {{ $order->id }}</h3>
        <hr>
        <h5>To: {{ $order->name }}</h5>
        <h5>Phone: {{ $order->phone }}</h5>
        <h5>Address: {{ $order->address }}</h5>
        <h5>Order Placed: {{ $order->created_at->toFormattedDateString() }}</h5>
        <br>
        <h5>Order items: </h5>
        <table class="table table-bordered">
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->title }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price }}</td>
                </tr>
            @endforeach
            <tr>
                <td></td>
                <th>Total</th>
                <td>{{ $order->total }}</td>
            </tr>
        </table>
    </div>
@endsection