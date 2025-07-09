<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources\DepartmentResource\Pages;

use Atendwa\Filakit\Pages\CreateRecord;
use Atendwa\Msingi\Filament\Resources\DepartmentResource;

class CreateDepartment extends CreateRecord
{
    protected static string $resource = DepartmentResource::class;
}
