<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources\ApiKeyResource\Pages;

use Atendwa\Filakit\Pages\ListRecords;
use Atendwa\Msingi\Filament\Resources\ApiKeyResource;

class ListApiKeys extends ListRecords
{
    protected static string $resource = ApiKeyResource::class;
}
