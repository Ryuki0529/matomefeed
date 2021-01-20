<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRssLoadListsTableColumnExcFilter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rss_load_lists', function (Blueprint $table) {
            $table->text('exc_filter')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rss_load_lists', function (Blueprint $table) {
            $table->dropColumn('exc_filter');
        });
    }
}
