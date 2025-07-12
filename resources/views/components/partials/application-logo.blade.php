@props(['light' => true])

@php
    $src = match ($light) {
        true =>asset('images/branding/white_logo.png'),
        false =>asset('images/branding/logo.png'),
    }
@endphp

<header {{ $attributes->merge(['class' => 'flex flex-col gap-4']) }}>
    <div aria-hidden="true">
        <img src="{{ $src }}" alt="" class="w-40 md:w-44"/>
    </div>
</header>
