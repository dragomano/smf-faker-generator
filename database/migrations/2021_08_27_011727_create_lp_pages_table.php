<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLpPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lp_pages', function (Blueprint $table) {
            $table->increments('page_id');
            $table->unsignedInteger('category_id')->default(0);
            $table->unsignedMediumInteger('author_id')->default(0);
            $table->string('alias', 255)->unique();
            $table->string('description', 255)->nullable();
            $table->mediumText('content');
            $table->string('type', 10)->default('bbc');
            $table->unsignedTinyInteger('permissions')->default(0);
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedInteger('num_views')->default(0);
            $table->unsignedInteger('num_comments')->default(0);
            $table->unsignedInteger('created_at')->default(0);
            $table->unsignedInteger('updated_at')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lp_pages');
    }
}
