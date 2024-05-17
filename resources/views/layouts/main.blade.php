<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Lucas">

        <title>@yield('title')</title>

        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        <header>
            @include('layouts.header')
        </header>

        <main>
            @yield('content')
        </main>

        <footer>
            <!-- TODO: add footer -->
        </footer>
    </body>
</html>
