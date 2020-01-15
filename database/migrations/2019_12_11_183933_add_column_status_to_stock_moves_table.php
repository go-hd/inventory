<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnStatusToStockMovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_moves', function (Blueprint $table) {
            $table->boolean('receiving_status')->comment('入庫ステータス')->nullable()->after('id');
            $table->boolean('shipping_status')->comment('出庫ステータス')->nullable()->after('id');
            $table->unsignedInteger('lot_id')->comment('ロットID')->after('id');
            $table->unsignedInteger('receiving_location_id')->comment('入庫拠点ID')->after('id');
            $table->unsignedInteger('shipping_location_id')->comment('出庫拠点ID')->after('id');

            $table->dropForeign('stock_moves_shipping_id_foreign');
            $table->dropForeign('stock_moves_receiving_id_foreign');
            $table->dropForeign('stock_moves_location_id_foreign');
            $table->dropColumn('shipping_id');
            $table->dropColumn('receiving_id');
            $table->dropColumn('location_id');

            $table->foreign('shipping_location_id')->references('id')->on('locations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('receiving_location_id')->references('id')->on('locations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('lot_id')->references('id')->on('lots')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('stock_moves')->truncate();
        Schema::table('stock_moves', function (Blueprint $table) {
            $table->dropForeign('stock_moves_shipping_location_id_foreign');
            $table->dropForeign('stock_moves_receiving_location_id_foreign');
            $table->dropForeign('stock_moves_lot_id_foreign');

            $table->dropColumn('shipping_status');
            $table->dropColumn('receiving_status');
            $table->dropColumn('lot_id');
            $table->dropColumn('shipping_location_id');
            $table->dropColumn('receiving_location_id');

            $table->unsignedInteger('shipping_id')->comment('出庫ID（在庫履歴）');
            $table->unsignedInteger('receiving_id')->comment('入庫ID（在庫履歴）');
            $table->unsignedInteger('location_id')->comment('相手拠点ID');

            $table->foreign('shipping_id')->references('id')->on('stock_histories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('receiving_id')->references('id')->on('stock_histories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onUpdate('cascade')->onDelete('cascade');
        });
    }
}
