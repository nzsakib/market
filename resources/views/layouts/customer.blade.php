<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Market Ecommerce</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body>
    <div class="container mt-3 mb-3">
        @include('navbar')
    </div>
    <div id="app">
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <div class="greeting">
                        Hello, {{ $user->name }}
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#">My Accounts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">My Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Wishlist</a>
                        </li>
                    </ul>
                </div>
                <div class="col-8">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>