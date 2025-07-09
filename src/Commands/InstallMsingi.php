<?php

declare(strict_types=1);

namespace Atendwa\Msingi\Commands;

use Atendwa\Msingi\MsingiServiceProvider;
use Atendwa\Support\Command;
use Illuminate\Support\Facades\File;

class InstallMsingi extends Command
{
    protected $signature = 'msingi:install';

    protected $description = 'Install the msingi package';

    protected string $provider = MsingiServiceProvider::class;

    /**
     * @var class-string[]
     */
    protected array $resources = [

    ];

    public function handle(): void
    {
        $this->preInstall();

        $this->publishAssets();

        collect([app_path('Actions'), app_path('Concerns'), app_path('Contracts'),
            app_path('Helpers'), app_path('Jobs'), app_path('Console/Commands'),
            app_path('Filament'), app_path('Support'), app_path('Services'),
            base_path('components'), base_path('features'),
        ])->each(fn (string $dir) => File::ensureDirectoryExists($dir));

        $this->finish();
    }
}
