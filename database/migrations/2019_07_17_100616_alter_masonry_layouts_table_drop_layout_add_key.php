<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMasonryLayoutsTableDropLayoutAddKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('masonry_layouts', function($table) {
            $table->dropColumn('layout');
        });

        Schema::table('masonry_layouts', function($table) {
            $table->string('key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('masonry_layouts', function($table) {
            $table->dropColumn('key');
        });
    }
}
