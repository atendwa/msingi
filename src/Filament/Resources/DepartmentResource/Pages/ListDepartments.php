<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources\DepartmentResource\Pages;

use Atendwa\Filakit\Actions\Action;
use Atendwa\Filakit\Pages\ListRecords;
use Atendwa\Msingi\Contracts\HandlesDepartmentSynchronisation;
use Atendwa\Msingi\Filament\Resources\DepartmentResource;
use Atendwa\Msingi\Models\Department;
use Illuminate\Support\Facades\Gate;

class ListDepartments extends ListRecords
{
    protected static string $resource = DepartmentResource::class;

    protected function actions(): array
    {
        $contract = HandlesDepartmentSynchronisation::class;

        return [
            Action::make('sync-departments')->icon('heroicon-o-arrow-path')
                ->action(fn () => asInstanceOf(app($contract), $contract)->sync())
                ->color('success')->requiresConfirmation()->visible(every([
                    Gate::allows('create', Department::class),
                    boolval(config('msingi.models.use_departments')),
                ])),
        ];
    }
}
