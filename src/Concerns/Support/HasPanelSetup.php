<?php

namespace Atendwa\Msingi\Concerns\Support;

use Atendwa\Filakit\Panel;
use Atendwa\Msingi\Models\Tenant;

trait HasPanelSetup
{
    public function panel(Panel $panel): Panel
    {
        return $this->setupPanel($panel);
    }

    protected function setupPanel(Panel $panel): Panel
    {
        return $this->hasTenancy ? $panel->tenant(Tenant::class) : $panel;
    }
}
