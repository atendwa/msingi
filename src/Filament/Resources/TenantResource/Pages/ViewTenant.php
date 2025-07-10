<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources\TenantResource\Pages;

use Atendwa\Filakit\Pages\ViewRecord;
use Atendwa\Msingi\Filament\Resources\TenantResource;

class ViewTenant extends ViewRecord
{
    protected static string $resource = TenantResource::class;

    protected array $relations = [['relation' => 'department']];
}
