<?php

declare(strict_types=1);

use Atendwa\Msingi\Models\Tenant;
use Atendwa\Msingi\Support\MsingiCacheKeys;
use Filament\Facades\Filament;

if (! function_exists('systemTenant')) {
    function systemTenant(): Tenant
    {
        $column = 'is_default';

        return Tenant::query()->where($column, true)->firstOrFail();
    }
}

if (! function_exists('defaultTenant')) {
    function defaultTenant(): Tenant
    {
        $column = 'is_default';

        return cache()->rememberForever(
            MsingiCacheKeys::FILAMENT_DEFAULT_TENANT,
            fn () => Tenant::query()->where($column, true)->firstOrFail()
        );
    }
}

if (! function_exists('tenantID')) {
    function tenantID(): int
    {
        $id = activeTenantID();

        if (blank($id)) {
            $id = systemTenant()->getKey();
        }

        return asInteger($id);
    }
}

if (! function_exists('inDepartmentTenant')) {
    function inDepartmentTenant(string $column = 'department_short_name'): bool
    {
        return Filament::getTenant()?->getAttribute($column) === auth()->user()?->getAttribute($column);
    }
}

if (! function_exists('isSystemStaff')) {
    function isSystemStaff(): bool
    {
        return auth()->user()?->isSystemStaff() ?? false;
    }
}
