<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>{{env('APP_NAME')}}</title>
</head>
<body>
    <div id="app">
        <div class="flex flex-col	items-center min-h-screen md:p-6 md:bg-gray-50">
            @yield('content')
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
