<?php

namespace Atendwa\Msingi\Providers\Filament;

use Atendwa\ActionWatch\ActionWatchPlugin;
use Atendwa\Filakit\Panel;
use Atendwa\Filakit\PanelProvider;
use Atendwa\Msingi\Concerns\Support\HasPanelSetup;
use Atendwa\Msingi\Filament\Pages\Dashboard;
use Atendwa\Msingi\Models\BaseUser;
use Atendwa\Settings\SettingsPlugin;
use Atendwa\Whitelist\WhitelistPlugin;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Contracts\Plugin;

class SystemPanelProvider extends PanelProvider
{
    use HasPanelSetup;

    protected array $pages = [Dashboard::class];

    protected bool $hasTenancy = false;

    public function panel(Panel $panel): Panel
    {
        return $this->setupPanel($panel)
            ->discoverResources(__DIR__ . '/../../Filament/Resources', 'Atendwa\\Msingi\\Filament\\Resources')
            ->discoverClusters(__DIR__ . '/../../Filament/Clusters', 'Atendwa\\Msingi\\Filament\\Clusters')
            ->discoverResources(app_path('Filament/System/Resources'), 'App\\Filament\\System\\Resources')
            ->discoverWidgets(__DIR__ . '/../../Filament/Widgets', 'Atendwa\\Msingi\\Filament\\Widgets')
            ->discoverClusters(app_path('Filament/System/Clusters'), 'App\\Filament\\System\\Clusters')
            ->discoverWidgets(app_path('Filament/System/Widgets'), 'App\\Filament\\System\\Widgets')
            ->discoverPages(__DIR__ . '/../../Filament/Pages', 'Atendwa\\Msingi\\Filament\\Pages')
            ->discoverPages(app_path('Filament/System/Pages'), 'App\\Filament\\System\\Pages');
    }

    public static function canAccess(string $id): bool
    {
        $user = auth()->user();

        if (! $user instanceof BaseUser) {
            return false;
        }

        return $user->isPrivileged();
    }

    /**
     * @param  Panel  $panel
     * @return Plugin[]
     */
    protected function plugins(Panel $panel): array
    {
        return [
            FilamentShieldPlugin::make()->checkboxListColumns(['default' => 1, 'sm' => 2])
                ->resourceCheckboxListColumns(['default' => 1, 'sm' => 2])
                ->gridColumns(['default' => 1, 'sm' => 2, 'lg' => 3])
                ->sectionColumnSpan(1),
            ActionWatchPlugin::make(),
            WhitelistPlugin::make(),
            SettingsPlugin::make(),
        ];
    }
}
