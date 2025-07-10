<?php

namespace Atendwa\Msingi\Filament\Pages;

use App\Filament\Home\Widgets\DashboardWidget;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasPageShield;

    protected static string $view = 'filament-panels::pages.dashboard';

    protected static ?string $activeNavigationIcon = 'heroicon-s-home';

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected ?string $heading = '';

    protected function getHeaderWidgets(): array
    {
        return [

        ];
    }
}
