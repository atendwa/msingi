<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Clusters;

use Filament\Clusters\Cluster;

class Core extends Cluster
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cube-transparent';

    protected static ?int $navigationSort = -1;
}
