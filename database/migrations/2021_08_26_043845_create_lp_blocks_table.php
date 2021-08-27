<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLpBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lp_blocks', function (Blueprint $table) {
            $table->increments('block_id');
            $table->unsignedMediumInteger('user_id')->default(0);
            $table->string('icon', 255)->nullable();
            $table->string('type', 255);
            $table->string('note', 255)->nullable();
            $table->text('content')->nullable();
            $table->string('placement', 10);
            $table->unsignedTinyInteger('priority')->default(0);
            $table->unsignedTinyInteger('permissions')->default(0);
            $table->unsignedTinyInteger('status')->default(1);
            $table->string('areas', 255)->default('all');
            $table->string('title_class', 255)->nullable();
            $table->string('title_style', 255)->nullable();
            $table->string('content_class', 255)->nullable();
            $table->string('content_style', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lp_blocks');
    }
}
