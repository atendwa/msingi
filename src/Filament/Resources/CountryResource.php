<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources;

use Atendwa\Filakit\Concerns\CustomizesFilamentResource;
use Atendwa\Filakit\Resource;
use Atendwa\Msingi\Filament\Clusters\Foundation;
use Atendwa\Msingi\Filament\Resources\CountryResource\Pages\CreateCountry;
use Atendwa\Msingi\Filament\Resources\CountryResource\Pages\EditCountry;
use Atendwa\Msingi\Filament\Resources\CountryResource\Pages\ListCountries;
use Atendwa\Msingi\Filament\Resources\CountryResource\Pages\ViewCountry;
use Atendwa\Msingi\Models\Country;
use Atendwa\Msingi\Support\AuditsComponent;
use Filament\Forms\Form;
use Filament\Resources\Pages\PageRegistration;
use Filament\Tables\Table;
use Throwable;

class CountryResource extends Resource
{
    use CustomizesFilamentResource;

    protected static ?string $cluster = Foundation::class;

    protected static ?string $model = Country::class;

    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form->schema([
            textInput('name'),
            textInput('continent'),
            textInput('flag'),
            textInput('short_code'),
            AuditsComponent::form(),
        ]);
    }

    /**
     * @throws Throwable
     */
    public static function table(Table $table): Table
    {
        self::$customTable = $table->columns([
            column('name'),
            column('continent'),
            column('flag'),
            column('short_code'),
        ]);

        return self::customTable();
    }

    /**
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => ListCountries::route('/'),
            'create' => CreateCountry::route('/create'),
            'view' => ViewCountry::route('/{record}'),
            'edit' => EditCountry::route('/{record}/edit'),
        ];
    }
}
