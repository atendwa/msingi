<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Attributes;

use Attribute;
use Illuminate\Contracts\Container\ContextualAttribute;
use Illuminate\Support\Collection;

#[Attribute(Attribute::TARGET_PARAMETER)]
class Categories implements ContextualAttribute
{
    public function __construct(public string $group, public string $key = 'id') {}

    /**
     * @return Collection<(int|string), mixed>
     */
    public static function resolve(self $attribute): Collection
    {
        return categories($attribute->group);
    }
}
