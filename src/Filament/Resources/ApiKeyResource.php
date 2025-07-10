<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources;

use Atendwa\Filakit\Concerns\CustomizesFilamentResource;
use Atendwa\Filakit\Resource;
use Atendwa\Msingi\Filament\Clusters\BasicData;
use Atendwa\Msingi\Filament\Resources\ApiKeyResource\Pages\CreateApiKeys;
use Atendwa\Msingi\Filament\Resources\ApiKeyResource\Pages\ListApiKeys;
use Atendwa\Msingi\Filament\Resources\ApiKeyResource\Pages\ViewApiKeys;
use Atendwa\Msingi\Models\ApiKey;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Pages\PageRegistration;
use Filament\Tables\Table;
use Throwable;

class ApiKeyResource extends Resource
{
    use CustomizesFilamentResource;

    protected static ?string $cluster = BasicData::class;

    protected static ?string $model = ApiKey::class;

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            textInput('name'),
            DatePicker::make('expires_at')->after(today()->toDateString())->format('Y-m-d')->nullable(),
        ]);
    }

    /**
     * @throws Throwable
     */
    public static function table(Table $table): Table
    {
        self::$customTable = $table->columns([
            column('name'),
            column('tokenable_type'),
            column('last_used_at')->date(),
            column('expires_at')->date(),
        ]);

        return self::customTable();
    }

    /**
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => ListApiKeys::route('/'),
            'create' => CreateApiKeys::route('/create'),
            'view' => ViewApiKeys::route('/{record}'),
        ];
    }
}
