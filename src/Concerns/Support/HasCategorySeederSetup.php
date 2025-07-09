<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Concerns\Support;

use Atendwa\Msingi\Models\Category;

trait HasCategorySeederSetup
{
    /**
     * @param  array<string>  $items
     */
    protected function category(string $name, array $items): void
    {
        $data = ['updated_by' => 1, 'created_by' => 1];

        Category::query()->updateOrCreate(['name' => $name], $data);

        collect($items)->each(
            fn ($type) => Category::query()->updateOrCreate(['name' => $type], [array_merge($data, ['group' => $name])])
        );
    }
}
