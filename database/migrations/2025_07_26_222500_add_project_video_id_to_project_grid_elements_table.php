<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::table('project_grid_elements', function (Blueprint $table) {
            $table->unsignedBigInteger('project_video_id')->nullable()->after('project_image_id');
            $table->foreign('project_video_id')->references('id')->on('project_videos')->onDelete('set null');
        });

        // Make project_image_id nullable (grid element can be image OR video)
        Schema::table('project_grid_elements', function (Blueprint $table) {
            $table->unsignedBigInteger('project_image_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('project_grid_elements', function (Blueprint $table) {
            $table->dropForeign(['project_video_id']);
            $table->dropColumn('project_video_id');
        });
    }
};
