<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    use Atendwa\Support\Concerns\Support\InferMigrationDownMethod;

    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('group')->nullable();
            $table->audit();

            $table->unique(['name', 'group']);
        });
    }
};
