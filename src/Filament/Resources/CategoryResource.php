<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources;

use Atendwa\Filakit\Concerns\CustomizesFilamentResource;
use Atendwa\Filakit\Resource;
use Atendwa\Msingi\Filament\Clusters\Core;
use Atendwa\Msingi\Filament\Resources\CategoryResource\Pages\CreateCategory;
use Atendwa\Msingi\Filament\Resources\CategoryResource\Pages\EditCategory;
use Atendwa\Msingi\Filament\Resources\CategoryResource\Pages\ListCategories;
use Atendwa\Msingi\Filament\Resources\CategoryResource\Pages\ViewCategory;
use Atendwa\Msingi\Models\Category;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Pages\PageRegistration;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Throwable;

class CategoryResource extends Resource
{
    use CustomizesFilamentResource;

    protected static ?string $cluster = Core::class;

    protected static ?string $model = Category::class;

    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name'),
            TextInput::make('group'),
            Toggle::make('is_active'),
        ]);
    }

    /**
     * @throws Throwable
     */
    public static function table(Table $table): Table
    {
        self::$customTable = $table->columns([
            TextColumn::make('name')->searchable(),
            TextColumn::make('group')->searchable(),
            IconColumn::make('is_active')->boolean(),
        ]);

        return self::customTable();
    }

    /**
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'view' => ViewCategory::route('/{record}'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
