<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources\TenantResource\Pages;

use Atendwa\Filakit\Pages\CreateRecord;
use Atendwa\Msingi\Filament\Resources\TenantResource;

class CreateTenant extends CreateRecord
{
    protected static string $resource = TenantResource::class;
}
