<?php

namespace Atendwa\Msingi\Support;

use Devonab\FilamentEasyFooter\EasyFooterPlugin;
use EightCedars\FilamentInactivityGuard\FilamentInactivityGuardPlugin;
use Filament\Contracts\Plugin;
use Hasnayeen\Themes\ThemesPlugin;
use Illuminate\Support\Collection;

class SharedPanelProviderPlugins
{
    /**
     * @return Collection<string, Plugin>
     */
    public function execute(): Collection
    {
        return collect([
//            'EasyFooterPlugin' => EasyFooterPlugin::make()->withLoadTime('Loaded in')->hiddenFromPagesEnabled()
//                ->withLogo('/images/branding/favicon.png', text: 'Powered by ICTS')
//                ->hiddenFromPages(['home/login', 'system/login', 'login']),
            'ThemesPlugin' => ThemesPlugin::make()->canViewThemesPage(fn () => false),
            'FilamentInactivityGuardPlugin' => FilamentInactivityGuardPlugin::make(),
        ]);
    }
}
