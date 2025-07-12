<?php

namespace Atendwa\Msingi\Providers\Filament;

use Atendwa\ActionWatch\ActionWatchPlugin;
use Atendwa\Filakit\Panel;
use Atendwa\Filakit\PanelProvider;
use Atendwa\Msingi\Concerns\Support\HasPanelSetup;
use Atendwa\Msingi\Filament\Pages\Dashboard;
use Atendwa\Msingi\Http\Middleware\PageVisitActivityLogMiddleware;
use Atendwa\Msingi\Models\BaseUser;
use Atendwa\Msingi\Support\SharedPanelProviderPlugins;
use Atendwa\Settings\SettingsPlugin;
use Atendwa\Whitelist\WhitelistPlugin;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Boquizo\FilamentLogViewer\FilamentLogViewerPlugin;
use Filament\Contracts\Plugin;

class SystemPanelProvider extends PanelProvider
{
    use HasPanelSetup;

    protected array $pages = [Dashboard::class];

    protected bool $hasTenancy = false;

    public function panel(Panel $panel): Panel
    {
        return $this->setupPanel($panel)->middleware([PageVisitActivityLogMiddleware::class])
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
     * @return Plugin[]
     */
    protected function plugins(Panel $panel): array
    {
        return app(SharedPanelProviderPlugins::class)->execute()->merge([
            FilamentShieldPlugin::make()->checkboxListColumns(['default' => 1, 'sm' => 2])
                ->resourceCheckboxListColumns(['default' => 1, 'sm' => 2])
                ->gridColumns(['default' => 1, 'sm' => 2, 'lg' => 3])
                ->sectionColumnSpan(1),
            FilamentLogViewerPlugin::make()->navigationIcon('heroicon-s-document-text')
                ->authorize(fn () => auth()->user()?->can('viewLogs') ?? false)
                ->navigationLabel('Logs'),
            ActionWatchPlugin::make(),
            WhitelistPlugin::make(),
            SettingsPlugin::make(),
        ])->values()->all();
    }
}
