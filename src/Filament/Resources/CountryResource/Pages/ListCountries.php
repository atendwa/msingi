<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources\CountryResource\Pages;

use Atendwa\Filakit\Pages\ListRecords;
use Atendwa\Msingi\Filament\Resources\CountryResource;

class ListCountries extends ListRecords
{
    protected static string $resource = CountryResource::class;
}
