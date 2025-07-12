<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Database\Seeders;

use Atendwa\Filakit\Utils\PanelPermissionResolver;
use Atendwa\Seedtrack\Concerns\PreventsDuplicateSeeding;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SeedPermissions extends Seeder
{
    use PreventsDuplicateSeeding;

    /**
     * @throws Exception
     */
    public function execute(): void
    {
        $inspect = ['viewInsights', 'viewPulse', 'viewHorizon', 'viewTelescope', 'viewLogs'];
        $this->permissions($inspect);

        Role::updateOrCreate(['name' => 'Developer'], ['name' => 'Developer'])->givePermissionTo($inspect);

        $util = app(PanelPermissionResolver::class);
        $panels = filament()->getPanels();

        collect($panels)->each(function ($panel) use ($util): void {
            $name = $util->execute($panel::class);

            Permission::updateOrCreate(['name' => $name], ['name' => $name]);
        });

        collect($panels)->each(fn ($panel) => Artisan::call(
            'shield:generate',
            ['--panel' => $panel->getId(), '--all' => true, '-n' => true, '-q' => true]
        ));
    }

    /**
     * @param  string[]  $inspect
     */
    private function permissions(array $inspect): void
    {
        collect($inspect)->each(
            fn ($permission) => Permission::updateOrCreate(['name' => $permission], ['name' => $permission])
        );
    }
}
