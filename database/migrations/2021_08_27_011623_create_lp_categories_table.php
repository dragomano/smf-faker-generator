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
        Schema::create('lp_categories', function (Blueprint $table) {
            $table->increments('category_id');
            $table->unsignedInteger('parent_id')->default(0);
            $table->string('slug', 255)->unique();
            $table->string('icon', 60)->nullable();
            $table->unsignedTinyInteger('priority')->default(0);
            $table->unsignedTinyInteger('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lp_categories');
    }
};
