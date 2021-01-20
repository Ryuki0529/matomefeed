<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRssLoadedFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rss_loaded_feeds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rss_load_list_id');
            $table->foreign('rss_load_list_id')
                ->references('id')->on('rss_load_lists')->onDelete('cascade');
            $table->string('title', 255);
            $table->text('url');
            $table->text('img')->nullable();
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
        Schema::table('rss_loaded_feeds', function (Blueprint $table) {
            $table->dropForeign('rss_loaded_feeds_rss_load_list_id_foreign');
        });
        Schema::dropIfExists('rss_loaded_feeds');
    }
}
