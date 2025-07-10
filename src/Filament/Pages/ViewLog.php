<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Pages;

use Atendwa\Msingi\Filament\Clusters\Insights;

class ViewLog extends \Boquizo\FilamentLogViewer\Pages\ViewLog
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
