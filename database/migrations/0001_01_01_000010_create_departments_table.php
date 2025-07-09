<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    use Atendwa\Support\Concerns\Support\InferMigrationDownMethod;

    public function shouldRun(): bool
    {
        return boolval(config('msingi.models.use_departments', true));
    }

    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table): void {
            $table->id();
            $table->slug();
            $table->name(true);
            $table->string('head_username')->index()->nullable();
            $table->string('delegate_username')->index()->nullable();
            $table->string('short_name');
            $table->string('parent_short_name')->nullable();
            $table->string('email')->nullable();
            $table->integer('sync_id')->nullable();
            $table->audit();
        });
    }
};
