@php
    $url = \Illuminate\Support\Facades\URL::current();
    $isVisible = str($url)->contains('login');
    $alignment = 'top-center';
@endphp

@if (filament()->hasDarkMode() && ! filament()->hasDarkModeForced() && $isVisible)
    <div
        @class([
            'auth-theme-switcher fixed z-40 flex w-full p-4',
            'top-0' => str_contains($alignment, 'top'),
            'bottom-0' => str_contains($alignment, 'bottom'),
            'justify-start' => str_contains($alignment, 'left'),
            'justify-end' => str_contains($alignment, 'right'),
            'justify-center' => str_contains($alignment, 'center'),
        ])
    >
        <div class="rounded-lg bg-gray-50 dark:bg-gray-950">
            <div
                x-data="{
                    theme: null,

                    init: function () {
                        this.theme = localStorage.getItem('theme') || 'system'

                        $dispatch('theme-changed', theme)

                        $watch('theme', (theme) => {
                            $dispatch('theme-changed', theme)
                        })
                    },
                }"
                class="fi-theme-switcher grid grid-flow-col gap-x-1"
            >
                <x-msingi::button.switch icon="heroicon-m-sun" theme="light" />
                <x-msingi::button.switch icon="heroicon-m-moon" theme="dark" />
                <x-msingi::button.switch icon="heroicon-m-computer-desktop" theme="system" />
            </div>
        </div>
    </div>
@endif
