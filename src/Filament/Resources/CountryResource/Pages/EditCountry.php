<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources\CountryResource\Pages;

use Atendwa\Filakit\Pages\EditRecord;
use Atendwa\Msingi\Filament\Resources\CountryResource;

class EditCountry extends EditRecord
{
    protected static string $resource = CountryResource::class;
}
