@if(auth()->user()->teams->count() > 1)
    <x-filament::modal width="lg" :slide-over="0" :stickyHeader="true" heading="Change Team"
                       description="Select a team to switch to and continue working seamlessly."
    >
        <x-slot name="trigger">
            <x-filament::button icon="heroicon-s-chevron-up-down" color="gray" icon-position="after">
                {{ active_team()->name }}
            </x-filament::button>
        </x-slot>

        <livewire:switch-team/>
    </x-filament::modal>
@endif
