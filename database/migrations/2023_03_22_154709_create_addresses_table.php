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
        $this->down();
        Schema::connection('sqlite')->create('addresses', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name');
            $table->string('type');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('parentId')->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::connection('sqlite')->dropIfExists('addresses');
    }
};
