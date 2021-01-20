<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSiteListsTableClumeCategoryId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->change();
            $table->foreign('category_id')
                ->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_lists', function (Blueprint $table) {
            $table->dropForeign('site_lists_category_id_foreign');
            $table->bigInteger('category_id')->change();
        });
    }
}
