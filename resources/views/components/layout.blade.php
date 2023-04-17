@props([
    'title' => null,
    'scripts' => ['resources/js/app.js'],
])

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            Список дел
            @isset($title) &mdash; {{ $title }} @endisset
        </title>
        @vite(['resources/css/app.scss', ...$scripts])
    </head>
    <body>
        {{ $slot }}
    </body>
</html>
