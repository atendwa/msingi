<?php

namespace Atendwa\Msingi\Concerns\Models;

use Illuminate\Foundation\Auth\User;

trait AccessSystemInsights
{
    public function canViewInsight(string $permission): bool
    {
        $user = auth()->user();

        if (! $user instanceof User) {
            return false;
        }

        return $user->can($permission) ?? false;
    }
}
