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
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->string('title')->nullable();
            $table->text('simpleDescription')->nullable();
            $table->text('detailDescription')->nullable();
            $table->ulid('token')->nullable();
            $table->tinyInteger('category_id');
            $table->boolean('isDraft');
            $table->integer('author_id');
            $table->tinyInteger('ratingValue')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
