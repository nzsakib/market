@extends('layouts.customer')

@section('content')
    <div class="containerss">
        <table class="table table-bordered">
            <tr class="text-center">
                <th>Order Number</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Order date</th>
            </tr>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->total }}</td>
                    <td><button class="btn btn-outline-primary">{{ $order->status }}</button></td>
                    <td>{{ $order->created_at->toFormattedDateString() }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection