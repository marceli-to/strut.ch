<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGridElementsTableChangeArticleIdToNewsId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grid_elements', function($table) {
            $table->dropColumn('article_id');
            $table->integer('news_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('news_id', function (Blueprint $table) {
            $table->dropColumn('news_id');
        });
    }
}
