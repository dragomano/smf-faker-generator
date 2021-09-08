<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembergroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membergroups', function (Blueprint $table) {
            $table->unsignedSmallInteger('id_group')->autoIncrement();
            $table->string('group_name', 80)->default('');
            $table->mediumText('description');
            $table->string('online_color', 20)->default('');
            $table->mediumInteger('min_posts')->default(-1);
            $table->unsignedSmallInteger('max_messages')->default(0);
            $table->string('icon', 255)->default('');
            $table->tinyInteger('group_type')->default(0);
            $table->tinyInteger('hidden')->default(0);
            $table->smallInteger('id_parent')->default(-2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('membergroups');
    }
}
