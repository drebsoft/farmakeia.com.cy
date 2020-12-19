<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{ $headerSlot ?? '' }}

        <link rel="apple-touch-icon" sizes="180x180" href="{{ url('/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ url('/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ url('/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ url('/site.webmanifest') }}">
        <link rel="canonical" href="{{ Request::url() }}" />
        <meta name="theme-color" content="#77b251">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        {{ $extrastyles ?? '' }}

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.js" defer></script>
        {{ $scriptloads ?? '' }}
        @livewireStyles

    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased bg-gray-100">

            @include('layouts.partials.header')

            {{ $slot }}

            @include('layouts.partials.footer')

        </div>
        {{ $scripts ?? '' }}

        @livewireScripts

        <script defer src='https://static.cloudflareinsights.com/beacon.min.js'
                data-cf-beacon='{"token": "a129c661ce744125ae8915fb461dd828"}'
        ></script>
    </body>
</html>
