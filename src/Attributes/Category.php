<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Attributes;

use Attribute;
use Illuminate\Contracts\Container\ContextualAttribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
class Category implements ContextualAttribute
{
    public function __construct(public string $name) {}

    public static function resolve(self $attribute): ?\Atendwa\Msingi\Models\Category
    {
        return category($attribute->name);
    }
}
