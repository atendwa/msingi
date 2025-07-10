<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources;

use Atendwa\Filakit\Concerns\CustomizesFilamentResource;
use Atendwa\Filakit\Resource;
use Atendwa\Msingi\Filament\Clusters\Core;
use Atendwa\Msingi\Filament\Resources\ActivityLogResource\Pages\ListActivityLogs;
use Atendwa\Msingi\Filament\Resources\ActivityLogResource\Pages\ViewActivityLog;
use Atendwa\Msingi\Models\ActivityLog;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\PageRegistration;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Throwable;

class ActivityLogResource extends Resource
{
    use CustomizesFilamentResource;

    protected static ?string $recordTitleAttribute = 'event';

    protected static ?string $cluster = Core::class;

    protected static ?string $model = ActivityLog::class;

    protected static ?int $navigationSort = 4;

    public static function infolist(Infolist $infolist): Infolist
    {
        $properties = $infolist->record?->getAttribute('properties');

        if (! $properties instanceof Collection) {
            $properties = collect();
        }

        $attributes = $properties->get('attributes');
        $attributes = is_array($attributes) ? $attributes : [];

        $old = $properties->get('old');
        $old = is_array($old) ? $old : [];

        return $infolist->schema([
            Fieldset::make('')->columns(3)->schema([
                textEntry('log_name'),
                textEntry('event'),
                textEntry('description'),
                textEntry('subject_type'),
                textEntry('subject_id'),
                textEntry('causer_type'),
                textEntry('causer_id'),
                textEntry('created_at')->date(),
                textEntry('updated_at')->date(),
            ]),
            KeyValueEntry::make('changes')->state($attributes),
            KeyValueEntry::make('old')->state($old),
        ]);
    }

    /**
     * @throws Throwable
     */
    public static function table(Table $table): Table
    {
        $column = 'log_name';
        $options = ActivityLog::query()->select($column)->pluck($column)->unique()->sort()->all();

        self::$customTable = $table->filters([select_filter($column, $options)])->columns([
            column($column),
            column('event'),
            column('description'),
            column('subject_type')->class(),
            column('subject.name')->label('Subject'),
            column('causer_type')->class(),
            column('causer.name')->label('Causer'),
        ]);

        return self::customTable();
    }

    /**
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => ListActivityLogs::route('/'),
            'view' => ViewActivityLog::route('/{record}'),
        ];
    }
}
