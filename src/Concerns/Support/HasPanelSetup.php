<?php

namespace Atendwa\Msingi\Concerns\Support;

use Atendwa\Filakit\Panel;
use Atendwa\Msingi\Models\Tenant;
use Hasnayeen\Themes\Http\Middleware\SetTheme;

trait HasPanelSetup
{
    public function panel(Panel $panel): Panel
    {
        return $this->setupPanel($panel);
    }

    protected function setupPanel(Panel $panel): Panel
    {
        if ($this->hasTenancy) {
            $panel = $panel->tenant(Tenant::class);
        }

        return match ($this->hasTenancy) {
            true => $panel->tenantMiddleware([SetTheme::class]),
            false => $panel->middleware([SetTheme::class]),
        };
    }
}
