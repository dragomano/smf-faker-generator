<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLpParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lp_params', function (Blueprint $table) {
            $table->unsignedInteger('item_id');
            $table->string('type', '10')->default('block');
            $table->string('name', 60);
            $table->string('value', 255)->nullable();
            $table->primary(['item_id', 'type', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lp_params');
    }
}
