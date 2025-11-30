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
        Schema::create('board_permissions_view', function (Blueprint $table) {
            $table->smallInteger('id_group')->default(0);
            $table->unsignedSmallInteger('id_board');
            $table->smallInteger('deny');
            $table->primary(['id_group', 'id_board', 'deny']);
            $table->foreign('id_board')->references('id_board')->on('boards')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_permissions_view');
    }
};
