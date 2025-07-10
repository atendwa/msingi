<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Filament\Resources\DepartmentResource\Pages;

use Atendwa\Filakit\Actions\Action;
use Atendwa\Filakit\Pages\ViewRecord;
use Atendwa\Msingi\Filament\Resources\DepartmentResource;
use Atendwa\Msingi\Models\Department;
use Atendwa\Msingi\Models\Tenant;
use Exception;
use Throwable;

class ViewDepartment extends ViewRecord
{
    protected static string $resource = DepartmentResource::class;

    protected array $relations = [['relation' => 'tenant']];

    /**
     * @throws Exception
     */
    protected function actions(): array
    {
        $department = asInstanceOf($this->record, Department::class);

        return [
            Action::make('make-tenant')->label('Make Tenant')->icon((new Tenant())->getIcon())
                ->color('success')->requiresConfirmation()->visible(blank($department->tenant))
                ->action(function () use ($department): void {
                    try {
                        Department::updateOrCreateTenant($department, true);

                        notify('Tenant created successfully.')->success();
                    } catch (Throwable $throwable) {
                        notify($throwable)->error();
                    }
                }),
        ];
    }
}
