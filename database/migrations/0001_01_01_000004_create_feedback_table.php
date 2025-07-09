<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table): void {
            $table->id();
            $table->slug();
            $table->unsignedInteger('category_id')->nullable()->index();
            $table->string('title')->nullable();
            $table->text('comments');
            $table->audit();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
