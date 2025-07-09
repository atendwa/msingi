<?php

namespace Atendwa\Msingi\Contracts;

interface InsightsUser
{
    public function canViewInsight(string $permission): bool;
}
