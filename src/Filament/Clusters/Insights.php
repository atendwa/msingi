<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Clusters;

use BackedEnum;
use Filament\Clusters\Cluster;

class Insights extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    public static function canAccess(): bool
    {
        return auth()->user()?->canAny(['viewHorizon', 'viewPulse', 'viewTelescope', 'viewLogs']) ?? false;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }
}
