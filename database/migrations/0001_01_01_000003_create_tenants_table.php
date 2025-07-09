<?php

use Atendwa\Msingi\Models\Tenant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table): void {
            $table->id();
            $table->slug();
            $table->nullableMorphs('owner');
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->string('head_username')->index()->nullable();
            $table->string('delegate_username')->index()->nullable();
            $table->string('department_short_name')->index()->nullable();
            $table->boolean('is_default')->default(false)->index();
            $table->audit();
        });

        Schema::create('tenant_user', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Tenant::class)->index()->constrained();
            $table->string('username')->index();

            $table->unique(['tenant_id', 'username']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
        Schema::dropIfExists('tenant_user');
    }
};
