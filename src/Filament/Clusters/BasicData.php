<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Clusters;

use Filament\Clusters\Cluster;

class BasicData extends Cluster
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rocket-launch';

    protected static ?int $navigationSort = -1;
}
