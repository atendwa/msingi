<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources\CategoryResource\Pages;

use Atendwa\Filakit\Pages\EditRecord;
use Atendwa\Msingi\Filament\Resources\CategoryResource;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;
}
