<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Market Ecommerce</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body>
    <div class="container mt-3 mb-3">
        @include('vendor.navbar')
    </div>
    <div id="app">
        <div class="container">
            <div class="row">
                <div class="col-2">
                    <div class="greeting">
                        Hello, {{ auth()->user()->name }}
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('vendor.profile') }}">My Accounts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('vendor.productList') }}">List Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('vendor.productAdd') }}">Add a Product</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('vendor.newOrders') }}">New Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('vendor.productAdd') }}">Sold Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/logout">Logout</a>
                        </li>
                    </ul>
                </div>
                <div class="col-10">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>