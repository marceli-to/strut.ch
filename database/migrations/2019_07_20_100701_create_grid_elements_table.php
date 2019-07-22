<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGridElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grid_elements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('grid_id')->unsigned();
            $table->integer('post_id')->unsigned()->nullable();
            $table->integer('article_id')->unsigned()->nullable();
            $table->integer('position')->default(0);
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
        Schema::dropIfExists('grid_elements');
    }
}
