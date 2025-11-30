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
        Schema::create('lp_pages', function (Blueprint $table) {
            $table->increments('page_id');
            $table->unsignedInteger('category_id')->default(0);
            $table->unsignedMediumInteger('author_id')->default(0);
            $table->string('slug', 255)->unique();
            $table->string('type', 10)->default('bbc');
            $table->string('entry_type', 10)->default('default');
            $table->unsignedTinyInteger('permissions')->default(0);
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedInteger('num_views')->default(0);
            $table->unsignedInteger('num_comments')->default(0);
            $table->unsignedInteger('created_at')->default(0);
            $table->unsignedInteger('updated_at')->default(0);
            $table->unsignedInteger('deleted_at')->default(0);
            $table->unsignedInteger('last_comment_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lp_pages');
    }
};
