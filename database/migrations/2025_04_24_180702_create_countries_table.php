<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    use Atendwa\Support\Concerns\Support\InferMigrationDownMethod;

    public function shouldRun(): bool
    {
        return boolval(config('msingi.models.use_countries', false));
    }

    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->string('continent');
            $table->string('flag');
            $table->string('short_code')->unique();
            $table->audit();
        });
    }
};
