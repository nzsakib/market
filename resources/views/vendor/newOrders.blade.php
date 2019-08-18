@extends('layouts.vendor')

@section('content')
    <h3>New Orders</h3>
    <hr>
    <table class="table table-bordered">
        <tr>
            <th>Order id</th>
            <th>Title</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Status</th>
        </tr>
    
    @foreach ($orders as $order)
        <tr>
            <td>{{ $order->order_id }}</td>
            <td>{{ $order->product->title }}</td>
            <td>{{ $order->quantity }}</td>
            <td>{{ $order->price }}</td>
            <td>{{ $order->order->status }}</td>
        </tr>
    @endforeach

    </table>
@endsection