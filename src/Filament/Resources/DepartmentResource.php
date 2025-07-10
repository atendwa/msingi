<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources;

use Atendwa\Filakit\Concerns\CustomizesFilamentResource;
use Atendwa\Filakit\Resource;
use Atendwa\Msingi\Filament\Clusters\BasicData;
use Atendwa\Msingi\Filament\Resources\DepartmentResource\Pages\CreateDepartment;
use Atendwa\Msingi\Filament\Resources\DepartmentResource\Pages\EditDepartment;
use Atendwa\Msingi\Filament\Resources\DepartmentResource\Pages\ListDepartments;
use Atendwa\Msingi\Filament\Resources\DepartmentResource\Pages\ViewDepartment;
use Atendwa\Msingi\Models\Department;
use Filament\Forms\Form;
use Filament\Resources\Pages\PageRegistration;
use Filament\Tables\Table;
use Throwable;

class DepartmentResource extends Resource
{
    use CustomizesFilamentResource;

    protected static ?string $cluster = BasicData::class;

    protected static ?string $model = Department::class;

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form->schema([
            textInput('name'),
            textInput('short_name'),
            relationship('head', 'username', false, 'head_username')
                ->placeholder(fn ($context): string => $context == 'view' ? 'N/A' : 'Select an option'),
            relationship('delegate', 'username', false, 'delegate_username')
                ->placeholder(fn ($context): string => $context == 'view' ? 'N/A' : 'Select an option'),
            textInput('email', false)->email()->empty(),
            textInput('sync_id', false)->numeric(),
            toggle(),
        ]);
    }

    /**
     * @throws Throwable
     */
    public static function table(Table $table): Table
    {
        self::$customTable = $table->columns([
            column('name'),
            column('short_name'),
            column('head_username'),
            column('delegate_username'),
        ]);

        return self::customTable();
    }

    /**
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => ListDepartments::route('/'),
            'create' => CreateDepartment::route('/create'),
            'view' => ViewDepartment::route('/{record}'),
            'edit' => EditDepartment::route('/{record}/edit'),
        ];
    }
}
