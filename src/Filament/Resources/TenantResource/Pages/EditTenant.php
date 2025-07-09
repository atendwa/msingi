<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources\TenantResource\Pages;

use Atendwa\Filakit\Pages\EditRecord;
use Atendwa\Msingi\Filament\Resources\TenantResource;

class EditTenant extends EditRecord
{
    protected static string $resource = TenantResource::class;
}
