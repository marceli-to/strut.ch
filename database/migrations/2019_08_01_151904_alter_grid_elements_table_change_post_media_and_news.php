<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGridElementsTableChangePostMediaAndNews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grid_elements', function($table)
        {
            $table->dropColumn('news_id');
            $table->dropColumn('post_media_id');
        });

        Schema::table('grid_elements', function($table)
        {
            $table->integer('post_media_id')->unsigned()->nullable();
            $table->integer('news_id')->unsigned()->nullable();    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
