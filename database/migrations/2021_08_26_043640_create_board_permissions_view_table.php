<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardPermissionsViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_permissions_view', function (Blueprint $table) {
            $table->smallInteger('id_group')->default(0);
            $table->unsignedSmallInteger('id_board');
            $table->smallInteger('deny');
            $table->foreign('id_board')->references('id_board')->on('boards')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('board_permissions_view');
    }
}
