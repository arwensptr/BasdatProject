<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name','Farmacheat') }}</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen antialiased">
    {{-- TIDAK ADA CONTAINER PEMBATAS DI SINI — biar halaman auth bisa full screen --}}
    {{ $slot }}
</body>
</html>
