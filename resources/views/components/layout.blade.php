@props([
    'title' => null,
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
        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        {{ $slot }}
    </body>
</html>
