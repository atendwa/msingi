<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::table('notifications', fn () => when(DB::getDriverName() === 'pgsql',
            fn () => DB::statement('ALTER TABLE notifications ALTER COLUMN data TYPE jsonb USING data::jsonb')
        ));
    }

    public function down(): void
    {
        Schema::table('notifications', fn () => when(DB::getDriverName() === 'pgsql',
            fn () => DB::statement('ALTER TABLE notifications ALTER COLUMN data TYPE text USING data::text')
        ));
    }
};
