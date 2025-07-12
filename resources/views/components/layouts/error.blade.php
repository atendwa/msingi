@php
    $auth = auth()->check();
@endphp

@props([
    'code',
    'title',
    'caption',
    'route' => true,
    'link' => null,
    'linkTitle' => null,
])

<x-msingi::layouts.auth :$title>
    <x-msingi::containers.auth-body class="min-h-lvh w-full justify-between gap-10 py-10">
        @csrf
        <x-msingi::partials.application-logo :light="false"/>

        <section class="flex flex-1 flex-col">
            <div class="my-auto">
                <h1 class="outlined-text mt-6 text-8xl font-bold">{{ $code }}</h1>

                <h2 class="mt-6 text-4xl font-semibold text-blue-600">{{ $title }}</h2>

                <p class="mt-3 max-w-sm text-lg">{{ $caption }}</p>
            </div>

            @if ($link || $route)
                @php
                    $default = route('welcome');
                    $defaultLinkTitle = 'Home Page';

                    if ($auth) {
                        $defaultLinkTitle = 'Home';
                        $default = url('/home');
                    }

                    $link = $link ?? $default;

                    $linkTitle = $linkTitle ?? $defaultLinkTitle;
                @endphp

                <div class="mt-auto">
                    <a href="{{ $link }}" hreflang="en" class="group mt-8 inline-flex items-center gap-4 py-2">
                        <div
                                aria-hidden="true"
                                class="smooth flex items-center justify-center rounded-full border border-blue-200 p-2 text-blue-400 group-hover:-translate-x-2 group-focus:-translate-x-2"
                        >
                            <svg fill="currentColor" class="h-5 w-5 -translate-x-px" viewBox="0 0 24 24">
                                <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M7.72 12.53a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 1 1 1.06 1.06L9.31 12l6.97 6.97a.75.75 0 1 1-1.06 1.06l-7.5-7.5Z"
                                />
                            </svg>
                        </div>

                        <p
                                class="smooth text-base font-medium text-blue-600 underline underline-offset-8 group-hover:underline-offset-4 group-focus:underline-offset-4"
                        >
                            {{ $linkTitle }}
                        </p>
                    </a>
                </div>
            @endif
        </section>
    </x-msingi::containers.auth-body>
</x-msingi::layouts.auth>
