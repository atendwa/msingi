<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Concerns\Support;

use Atendwa\Filakit\Panel;
use Atendwa\Msingi\Models\Tenant;
use Filament\Navigation\NavigationItem;
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
        return $panel
            ->tenant($this->hasTenancy ? Tenant::class : null)
            ->navigationItems($this->navigationItems())
            ->plugins($this->getPlugins($panel));
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
