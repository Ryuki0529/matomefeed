<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRssLoadListsTableColumnFeedUpdateTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rss_load_lists', function (Blueprint $table) {
            $table->dateTime('feed_update_time')->nullable();
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
            $table->dropColumn('feed_update_time');
        });
    }
}
