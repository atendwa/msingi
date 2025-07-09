<?php

namespace Atendwa\Msingi\Concerns\Support;

use Atendwa\Msingi\Contracts\InsightsUser;

trait HasInsightPageGate
{
    public static function canAccess(): bool
    {
        $user = auth()->user();

        if (! $user instanceof InsightsUser) {
            return false;
        }

        return $user->canViewInsight(self::$permission);
    }
}
