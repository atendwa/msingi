<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Models;

use Atendwa\Msingi\Model;

class Feedback extends Model
{
    public string $icon = 'heroicon-o-chat-bubble-oval-left-ellipsis';

    protected $table = 'feedbacks';

    protected $guarded = ['id'];

    // todo: add resource
}
