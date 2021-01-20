<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRssSuggestionRssLoadedFeedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rss_loaded_feed_rss_suggestion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rss_suggestion_id');
            $table->foreign('rss_suggestion_id')
                ->references('id')->on('rss_suggestions')->onDelete('cascade');
            $table->unsignedBigInteger('rss_loaded_feed_id');
            $table->foreign('rss_loaded_feed_id')
                ->references('id')->on('rss_loaded_feeds')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rss_loaded_feed_rss_suggestion', function (Blueprint $table) {
            $table->dropForeign('rss_loaded_feed_rss_suggestion_rss_suggestion_id_foreign');
            $table->dropForeign('rss_loaded_feed_rss_suggestion_rss_loaded_feed_id_foreign');
        });
        Schema::dropIfExists('rss_loaded_feed_rss_suggestion');
    }
}
