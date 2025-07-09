<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources\CategoryResource\Pages;

use Atendwa\Filakit\Pages\CreateRecord;
use Atendwa\Msingi\Filament\Resources\CategoryResource;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
}
