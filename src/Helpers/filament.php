<?php

declare(strict_types=1);

use Filament\Forms\Components\Textarea;

if (! function_exists('json_field')) {
    function json_field(string $name): Textarea
    {
        return textArea($name)->visibleOn('view')
            ->formatStateUsing(function ($state): string {
                $data = asString(json_encode($state, JSON_PRETTY_PRINT));

                if (str($data)->is('[]')) {
                    return 'N/A';
                }

                return $data;
            })
            ->rows(function ($state): int {
                $data = json_decode(asString($state), true);

                if (! is_array($data)) {
                    return 1;
                }

                return count($data) + 2;
            });
    }
}
