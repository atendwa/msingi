<?php

namespace Atendwa\Msingi\Support;

use Filament\Forms\Components\Section;

class AuditsComponent
{
    public static function form(): Section
    {
        return Section::make('Audits')->collapsible()->collapsed()
            ->persistCollapsed()->columns(1)->schema([]);
    }

    public static function infolist(): \Filament\Infolists\Components\Section
    {
        return \Filament\Infolists\Components\Section::make('Audits')->collapsible()
            ->collapsed()->persistCollapsed()->columns(1)->schema([]);
    }
}
