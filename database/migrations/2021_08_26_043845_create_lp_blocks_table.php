<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lp_blocks', function (Blueprint $table) {
            $table->increments('block_id');
            $table->string('icon', 60)->nullable();
            $table->string('type', 255);
            $table->string('placement', 10);
            $table->unsignedTinyInteger('priority')->default(0);
            $table->unsignedTinyInteger('permissions')->default(0);
            $table->unsignedTinyInteger('status')->default(1);
            $table->string('areas', 255)->default('all');
            $table->string('title_class', 255)->nullable();
            $table->string('content_class', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lp_blocks');
    }
};
