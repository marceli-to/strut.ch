<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('project_videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->json('caption')->nullable();
            $table->integer('order')->default(-1);
            $table->integer('publish')->default(0);
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_videos');
    }
};
