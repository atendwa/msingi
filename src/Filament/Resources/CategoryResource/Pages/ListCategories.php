<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources\CategoryResource\Pages;

use Atendwa\Filakit\Pages\ListRecords;
use Atendwa\Msingi\Filament\Resources\CategoryResource;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;
}
