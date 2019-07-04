<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnProductIdToLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lots', function (Blueprint $table) {
            $table->dropForeign('lots_location_id_foreign');
            $table->dropColumn('location_id');
            $table->dropForeign('lots_brand_id_foreign');
            $table->dropColumn('brand_id');
            $table->unsignedInteger('product_id')->comment('商品ID')->after('id');
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->dropColumn('jan_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lots', function (Blueprint $table) {
            $table->unsignedInteger('brand_id')->comment('ブランドID')->after('id');
            $table->unsignedInteger('location_id')->comment('拠点ID')->after('id');
            $table->dropForeign('lots_product_id_foreign');
            $table->dropColumn('product_id');
            $table->string('jan_code')->comment('JANコード')->after('name');
        });
    }
}
