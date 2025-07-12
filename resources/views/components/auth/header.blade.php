@props([
    'title',
    'password' => false,
])

<header {{ $attributes }}>
    <x-msingi::partials.application-logo/>

    <h2 class="mt-4 max-w-md font-primary text-base font-medium text-slate-900 sm:text-lg md:text-xl">
        {{ $title }}
    </h2>

    @if ($password)
        <div class="text-balances mt-2">
            Your password should contain mixed case letters, numbers, symbols and be at least 8 characters long.
        </div>
    @endif

    {{ $slot }}
</header>
