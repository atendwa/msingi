@props([
    'title',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="font-secondary font-normal leading-6 antialiased">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ $title }} | {{ config('app.name', 'Laravel') }}</title>

        {{-- <link rel="stylesheet" href="{{ mix('css/app.css') }}"> --}}

        @vite('resources/css/app.css')
        @vite('resources/js/app.js')

        @livewireStyles

        @stack('head')
    </head>

    <body class="grid h-lvh grid-cols-12 overflow-hidden overscroll-none bg-blue-50 text-slate-600">
        <main class="relative col-span-12 -mr-0.5 overflow-y-auto border-t-4 border-blue-600 lg:col-span-7 lg:border-0">
            <section class="flex min-h-lvh items-center justify-center">
                {{ $slot }}
            </section>
        </main>

        <div class="col-span-5 hidden lg:block" aria-hidden="true">
            <x-msingi::svgs.pattern class="h-lvh" />
        </div>

        @livewireScripts

        @stack('scripts')
    </body>
</html>
