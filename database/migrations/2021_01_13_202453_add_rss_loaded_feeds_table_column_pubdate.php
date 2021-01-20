<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRssLoadedFeedsTableColumnPubdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rss_loaded_feeds', function (Blueprint $table) {
            $table->string('img_type', 20);
            $table->dateTime('pubdate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rss_loaded_feeds', function (Blueprint $table) {
            $table->dropColumn('img_type');
            $table->dropColumn('pubdate');
        });
    }
}
