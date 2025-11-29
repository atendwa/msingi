<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Custom;

use Atendwa\Msingi\Filament\Clusters\Insights;
use Boquizo\FilamentLogViewer\Actions\BackAction;
use Boquizo\FilamentLogViewer\Actions\DownloadAction;

class ViewLog extends \Boquizo\FilamentLogViewer\Pages\ViewLog
{
    public function getHeaderActions(): array
    {
        return [
            DownloadAction::make(withTooltip: true),
            BackAction::make(),
        ];
    }
    //    public static function getNavigationGroup(): ?string
    //    {
    //        return null;
    //    }
    //
    //    public static function getCluster(): ?string
    //    {
    //        return Insights::class;
    //    }

    public static function canAccess(): bool
    {
        return auth()->user()?->can('viewLogs') ?? false;
    }
}
