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
        Schema::create('messages', function (Blueprint $table) {
            $table->id('id_msg');
            $table->unsignedMediumInteger('id_topic')->default(0);
            $table->unsignedSmallInteger('id_board')->default(0);
            $table->unsignedInteger('poster_time')->default(0);
            $table->unsignedMediumInteger('id_member')->default(0);
            $table->string('subject', 255)->default('');
            $table->string('poster_name', 255)->default('');
            $table->string('poster_email', 255)->default('');
            $table->unsignedInteger('modified_time')->default(0);
            $table->text('body');
            $table->unsignedTinyInteger('approved')->default(1);
            $table->foreign('id_topic')->references('id_topic')->on('topics')->cascadeOnDelete();
            $table->foreign('id_board')->references('id_board')->on('boards')->cascadeOnDelete();
            $table->foreign('id_member')->references('id_member')->on('members')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
