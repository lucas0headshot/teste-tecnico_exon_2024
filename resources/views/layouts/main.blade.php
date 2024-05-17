<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Lucas">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

        <title>@yield('title')</title>

        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        <header>
            @include('layouts.header')
        </header>

        <main class="container mt-3 mb-3">
            @yield('content')
        </main>

        <footer>
            @include('layouts.footer')
        </footer>
    </body>
</html>
