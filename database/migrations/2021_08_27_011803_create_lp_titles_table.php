<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lp_titles', function (Blueprint $table) {
            $table->unsignedInteger('item_id');
            $table->string('type', '10')->default('block');
            $table->string('lang', 60);
            $table->string('title', 255)->nullable();
            $table->primary(['item_id', 'type', 'lang']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lp_titles');
    }
};
