<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Concerns\Support;

use Atendwa\Filakit\Panel;
use Atendwa\Msingi\Models\Tenant;
use Filament\Navigation\NavigationItem;
// use Hasnayeen\Themes\Http\Middleware\SetTheme;
use Hasnayeen\Themes\Http\Middleware\SetTheme;
use Throwable;

trait CustomizesFilamentPanel
{
    // todo: remove

    /**
     * @throws Throwable
     */
    public function panel(Panel $panel): Panel
    {
        return $this->basePanel($panel);
    }

    /**
     * @throws Throwable
     */
    protected function basePanel(Panel $panel): Panel
    {
        $panel = $panel
            ->tenant($this->hasTenancy ? Tenant::class : null)
            ->navigationItems($this->navigationItems())
            ->plugins($this->getPlugins($panel));

        return match ($this->hasTenancy) {
            true => $panel->tenantMiddleware([SetTheme::class]),
            false => $panel->middleware([SetTheme::class]),
        };
    }

    /**
     * @return array<NavigationItem>
     *
     * @throws Throwable
     */
    protected function navigationItems(): array
    {
        return [
            NavigationItem::make('home')->label('Quick Links')->icon('heroicon-o-squares-2x2')->url('/home'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function middleware(): array
    {
        return [];
    }
}
