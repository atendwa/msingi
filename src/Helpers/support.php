<?php

declare(strict_types=1);

use Atendwa\Msingi\Models\BaseUser;
use Atendwa\Msingi\Models\Category;
use Atendwa\Msingi\Models\Country;
use Illuminate\Support\Collection;

if (! function_exists('systemUsername')) {
    /**
     * @throws Throwable
     */
    function systemUsername(): string
    {
        $username = asString(setting('auth:system_username'));

        throw_if(blank($username), 'System username not set.');

        return $username;
    }
}

if (! function_exists('country')) {
    function country(string $name, string $column = 'name'): ?Country
    {
        return Country::query()->firstWhere($column, $name);
    }
}

if (! function_exists('systemUser')) {
    /**
     * @throws Throwable
     */
    function systemUser(): BaseUser
    {
        $column = 'username';

        return BaseUser::query()->where($column, systemUsername())->firstOrFail();
    }
}

if (! function_exists('categories')) {
    /**
     * @return Collection<(int|string), mixed>
     */
    function categories(string $group, string $column = 'name', string $id = 'id'): Collection
    {
        $field = 'group';

        return Category::query()->where($field, $group)->select([$id, $column])->pluck($column, $id);
    }
}

if (! function_exists('category')) {
    function category(string $name): ?Category
    {
        return Category::query()->firstWhere('name', $name);
    }
}

if (! function_exists('authID')) {
    /**
     * @throws Throwable
     */
    function authID(): int
    {
        return asInteger(auth()->id() ?? systemUser()->getAttribute('id'));
    }
}
