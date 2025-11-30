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
        Schema::create('topics', function (Blueprint $table) {
            $table->unsignedMediumInteger('id_topic')->autoIncrement();
            $table->unsignedTinyInteger('is_sticky')->default(0);
            $table->unsignedSmallInteger('id_board')->default(0);
            $table->unsignedBigInteger('id_first_msg')->default(0);
            $table->unsignedBigInteger('id_last_msg')->default(0);
            $table->unsignedMediumInteger('id_member_started')->default(0);
            $table->unsignedInteger('num_replies')->default(0);
            $table->unsignedInteger('num_views')->default(0);
            $table->unsignedTinyInteger('locked')->default(0);
            $table->unsignedTinyInteger('approved')->default(1);
            $table->foreign('id_board')->references('id_board')->on('boards')->cascadeOnDelete();
            $table->foreign('id_member_started')->references('id_member')->on('members')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
