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
        Schema::create('lp_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id');
            $table->string('type', 30)->default('block');
            $table->string('lang', 20);
            $table->string('title', 255)->nullable();
            $table->mediumText('content')->nullable();
            $table->string('description', 510)->nullable();
            $table->unique(['item_id', 'type', 'lang']);
            $table->index(['type', 'item_id', 'lang']);
            $table->index([DB::raw('title(100)')], 'title_prefix');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lp_translations');
    }
};
