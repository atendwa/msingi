<?php

namespace Atendwa\Msingi\Support;

use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;

class AuditsComponent
{
    public static function form(): Section
    {
        return Section::make('Audits')->collapsible()->collapsed()->persistCollapsed()->columns(1)
            ->visible(fn (?Model $model) => $model && permission('audit', model: $model))
            ->schema([]);
    }

    public static function infolist(): Section
    {
        return Section::make('Audits')->collapsible()->persistCollapsed()
            ->visible(fn (?Model $model) => $model && permission('audit', model: $model))->collapsed()
            ->columns(1)->schema([]);
    }
}
