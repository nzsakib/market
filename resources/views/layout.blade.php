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
        @yield('content')
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>