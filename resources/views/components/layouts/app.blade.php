<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>{{ config('app.name') }}</title>

        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}" />
        {{-- <link rel="preload" href="{{ asset('images/logo-white.png') }}" as="image" /> --}}
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link rel="preconnect" href="https://fonts.googleapis.com" />

        @vite('resources/css/app.css')
        @vite('resources/js/app.js')

        @livewireStyles

        @stack('head')
    </head>

    <body
        class="relative overflow-x-hidden font-primary leading-6 text-slate-700 antialiased"
        x-data="{
            showCancelSaleModal: false,

            closeCancelSaleModal() {
                this.showCancelSaleModal = false
            },
        }"
    >
        {{ $slot }}

        @livewireScripts
    </body>
</html>
