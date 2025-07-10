<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Custom;

use Atendwa\Msingi\Filament\Clusters\Insights;

class ListLogs extends \Boquizo\FilamentLogViewer\Pages\ListLogs
{
    public static function getNavigationGroup(): ?string
    {
        return null;
    }

    public static function getCluster(): ?string
    {
        return Insights::class;
    }
}
