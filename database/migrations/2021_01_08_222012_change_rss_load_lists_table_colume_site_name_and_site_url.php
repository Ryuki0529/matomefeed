<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeRssLoadListsTableColumeSiteNameAndSiteUrl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rss_load_lists', function (Blueprint $table) {
            $table->foreign('site_name')
                ->references('name')->on('site_lists')->onDelete('cascade');
            $table->foreign('site_url')
                ->references('url')->on('site_lists')->onDelete('cascade');
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
            $table->dropForeign('rss_load_lists_site_name_foreign');
            $table->dropForeign('rss_load_lists_site_url_foreign');
        });
    }
}
