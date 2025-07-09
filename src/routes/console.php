<?php

declare(strict_types=1);

use Atendwa\Support\Console\Commands\PruneModels;
use Illuminate\Support\Facades\Schedule;

Schedule::command('telescope:prune --hours=48')->daily();
Schedule::command(PruneModels::class)->daily();
