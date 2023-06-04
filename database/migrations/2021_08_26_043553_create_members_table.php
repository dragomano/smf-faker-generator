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
        Schema::create('members', function (Blueprint $table) {
            $table->unsignedMediumInteger('id_member')->autoIncrement();
            $table->string('member_name', 80)->unique()->default('');
            $table->unsignedInteger('date_registered')->default(0);
            $table->unsignedInteger('posts')->default(0);
            $table->unsignedInteger('id_group')->default(0);
            $table->string('real_name', 255)->unique()->default('');
            $table->string('passwd', 64)->default('');
            $table->string('email_address', 255)->unique()->default('');
            $table->date('birthdate')->default('1004-01-01');
            $table->unsignedTinyInteger('is_activated')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
};
