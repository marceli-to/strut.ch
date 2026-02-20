<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::table('home_grid_elements', function (Blueprint $table) {
            $table->unsignedBigInteger('project_video_id')->nullable()->after('project_image_id');
            $table->foreign('project_video_id')->references('id')->on('project_videos')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('home_grid_elements', function (Blueprint $table) {
            $table->dropForeign(['project_video_id']);
            $table->dropColumn('project_video_id');
        });
    }
};
