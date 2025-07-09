<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources\ActivityLogResource\Pages;

use Atendwa\Filakit\Concerns\UsesStatusTabs;
use Atendwa\Filakit\Pages\ListRecords;
use Atendwa\Msingi\Filament\Resources\ActivityLogResource;

class ListActivityLogs extends ListRecords
{
    use UsesStatusTabs;

    protected static string $resource = ActivityLogResource::class;
}
