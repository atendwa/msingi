<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources\TenantResource\Pages;

use Atendwa\Filakit\Pages\ListRecords;
use Atendwa\Msingi\Filament\Resources\TenantResource;

class ListTenants extends ListRecords
{
    protected static string $resource = TenantResource::class;
}
