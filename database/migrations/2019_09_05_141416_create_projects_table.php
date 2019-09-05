<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('name');
            $table->json('location');
            $table->integer('year');
            $table->json('description')->nullable();
            $table->json('info')->nullable();
            $table->integer('has_detail')->default(0);	
            $table->enum('status', ['Ausgeführt', 'In Planung', 'Studie']);
            $table->enum('competition', ['1. Preis', '2. Preis', 'Andere']);
            $table->integer('publish')->default(0);
            $table->integer('order')->default(-1);
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
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
        Schema::dropIfExists('projects');
    }
}
