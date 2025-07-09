<?php

use Rector\Config\RectorConfig;

return RectorConfig::configure()->withImportNames(removeUnusedImports: true)
    ->withRootFiles()->withPaths([
        __DIR__ . '/components',
        __DIR__ . '/features',
        __DIR__ . '/app',
    ])
    ->withPreparedSets(
        false,
        false,
        false,
        false,
        false,
        false,
        false,
        false,
        false,
        false,
        false,
        false,
        false,
        false,
        false,
    );
