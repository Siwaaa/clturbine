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
        <div class="flex justify-center items-center min-h-screen md:p-6 md:bg-gray-50">
            <div class="max-w-xl text-center space-y-4">
                <h1 class="text-2xl font-light">500. Внутренняя ошибка</h1>
                <p class="text-gray-600 text-sm">
                Что-то пошло не так. Попробуйте обратиться в поддержку или вернитесь немного назад.
                </p>
                <a href="https://client-turbine.ru" class="mt-4 underline">Перейти на главную</a>
            </div>
        </div>
    </div>
</body>
</html>
