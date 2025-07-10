<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources;

use Atendwa\Filakit\Concerns\CustomizesFilamentResource;
use Atendwa\Filakit\Resource;
use Atendwa\Msingi\Filament\Clusters\Core;
use Atendwa\Msingi\Filament\Resources\TenantResource\Pages\CreateTenant;
use Atendwa\Msingi\Filament\Resources\TenantResource\Pages\EditTenant;
use Atendwa\Msingi\Filament\Resources\TenantResource\Pages\ListTenants;
use Atendwa\Msingi\Filament\Resources\TenantResource\Pages\ViewTenant;
use Atendwa\Msingi\Models\Tenant;
use Filament\Forms\Form;
use Filament\Resources\Pages\PageRegistration;
use Filament\Tables\Table;
use Throwable;

class TenantResource extends Resource
{
    use CustomizesFilamentResource;

    protected static ?string $cluster = Core::class;

    protected static ?string $model = Tenant::class;

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            textInput('name'),
            textInput('description'),
            relationship('head', 'username', true, 'head_username')
                ->placeholder(fn ($context): string => $context == 'view' ? 'N/A' : 'Select an option'),
            relationship('delegate', 'username', false, 'delegate_username')
                ->placeholder(fn ($context): string => $context == 'view' ? 'N/A' : 'Select an option'),
            toggle(),
        ]);
    }

    /**
     * @throws Throwable
     */
    public static function table(Table $table): Table
    {
        self::$customTable = $table->columns([
            column('name')->headline(),
            column('description'),
            isActive(),
        ]);

        return self::customTable();
    }

    /**
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => ListTenants::route('/'),
            'create' => CreateTenant::route('/create'),
            'view' => ViewTenant::route('/{record}'),
            'edit' => EditTenant::route('/{record}/edit'),
        ];
    }
}
