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
        Schema::create('boards', function (Blueprint $table) {
            $table->unsignedSmallInteger('id_board')->autoIncrement();
            $table->unsignedTinyInteger('id_cat')->default(0);
            $table->unsignedTinyInteger('child_level')->default(0);
            $table->unsignedSmallInteger('id_parent')->default(0);
            $table->unsignedSmallInteger('board_order')->default(0);
            $table->string('member_groups', 255)->default('-1,0');
            $table->string('name', 255)->default('');
            $table->text('description');
            $table->unsignedMediumInteger('num_topics')->default(0);
            $table->unsignedMediumInteger('num_posts')->default(0);
            $table->foreign('id_cat')->references('id_cat')->on('categories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boards');
    }
};
