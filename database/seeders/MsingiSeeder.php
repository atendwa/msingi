<?php

namespace Atendwa\Msingi\Database\Seeders;

use Atendwa\Msingi\Contracts\ConfiguresApplication;
use Atendwa\Seedtrack\Attributes\SeederAttribute;
use Atendwa\Seedtrack\Concerns\PreventsDuplicateSeeding;
use Illuminate\Database\Seeder;
use Throwable;

#[SeederAttribute(order: -100)]
class MsingiSeeder extends Seeder
{
    use PreventsDuplicateSeeding;

    /**
     * @throws Throwable
     */
    public function execute(): void
    {
        $this->call([SeedPermissions::class]);

        $configurator = app(ConfiguresApplication::class);

        if (filled($configurator)) {
            $configurator->execute();
        }

        $this->call([CategorySeeder::class]);

        when(config('msingi.models.use_countries'), fn () => $this->call(CountrySeeder::class));
    }
}
