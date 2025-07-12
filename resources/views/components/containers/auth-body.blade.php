<form
    {{ $attributes->merge(['class' => 'max-w-lg w-full h-full px flex flex-col']) }}
    method="POST"
>
    @csrf

    {{ $slot }}
</form>
