<?php

namespace Atendwa\Msingi\Concerns\Models;

use Atendwa\Msingi\Models\Category;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToCategory
{
    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withoutGlobalScopes();
    }

    public function categoryId(): ?int
    {
        $id = $this->getAttribute('category_id');

        return match (is_numeric($id)) {
            true => (int) $id,
            false => null,
        };
    }
}
