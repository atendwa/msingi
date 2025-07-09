<?php

declare(strict_types=1);

namespace Atendwa\Msingi;

use Atendwa\Filakit\Contracts\ModelHasIcon;
use Atendwa\Msingi\Concerns\Models\HasAuditAttributes;
use Atendwa\Msingi\Contracts\Auditable;
use Atendwa\Support\Concerns\Models\HasModelUtilities;
use Atendwa\Support\Concerns\Models\SanitiseNullableColumns;
use Atendwa\Support\Concerns\Models\UsesIsActiveScope;
use Atendwa\Support\Contracts\Toggleable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends \Illuminate\Database\Eloquent\Model implements Auditable, ModelHasIcon, Toggleable
{
    use HasAuditAttributes;
    use HasModelUtilities;
    use SanitiseNullableColumns;
    use SoftDeletes;
    use UsesIsActiveScope;
    //    use LogsActivity; // todo

    public string $icon = 'heroicon-o-document-text';

    protected $guarded = ['id'];

    public function getIcon(): string
    {
        return $this->icon;
    }
}
