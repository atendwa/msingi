<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Custom;

use Atendwa\Msingi\Filament\Clusters\Insights;
use Boquizo\FilamentLogViewer\Actions\DownloadAction;
use Boquizo\FilamentLogViewer\Actions\DownloadBulkAction;
use Boquizo\FilamentLogViewer\Actions\ViewLogAction;
use Boquizo\FilamentLogViewer\Tables\LogsTable;
use Filament\Tables\Table;

class ListLogs extends \Boquizo\FilamentLogViewer\Pages\ListLogs
{
    public static function table(Table $table): Table
    {
        return LogsTable::configure($table)
            ->actions([ViewLogAction::make(), DownloadAction::make()])
            ->bulkActions([DownloadBulkAction::make()]);
    }

    public static function getNavigationGroup(): ?string
    {
        return null;
    }

    public static function getCluster(): ?string
    {
        return Insights::class;
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->can('viewLogs') ?? false;
    }
}
