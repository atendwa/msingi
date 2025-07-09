<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Database\Seeders;

use Atendwa\Msingi\Concerns\Support\HasCategorySeederSetup;
use Atendwa\Seedtrack\Concerns\PreventsDuplicateSeeding;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    use HasCategorySeederSetup;
    use PreventsDuplicateSeeding;

    public function execute(): void
    {
        $this->category('Feedback Types', [
            'General Feedback', 'User Experience', 'Feature Request', 'Bug Report', 'Quality of Service',
        ]);

        $this->category('User Types', ['Guest', 'Intern']);
    }
}
