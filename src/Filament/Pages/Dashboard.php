<?php

namespace Atendwa\Msingi\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasPageShield;

    protected static string | \BackedEnum | null $activeNavigationIcon = 'heroicon-s-home';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-home';

    protected ?string $heading = '';

    protected function getHeaderWidgets(): array
    {
        return [

        ];
    }
}
