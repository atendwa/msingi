<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources\CountryResource\Pages;

use Atendwa\Filakit\Pages\CreateRecord;
use Atendwa\Msingi\Filament\Resources\CountryResource;

class CreateCountry extends CreateRecord
{
    protected static string $resource = CountryResource::class;
}
