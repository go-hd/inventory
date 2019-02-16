<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('location_id')->comment('相手拠点ID');
            $table->unsignedInteger('lot_id')->comment('ロットID');
            $table->unsignedInteger('stock_history_type_id')->comment('在庫履歴種別ID');
            $table->integer('quantity')->comment('数量');
            $table->text('note')->comment('備考')->nullable();
            $table->timestamps();

            $table->foreign('location_id')->references('id')->on('locations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('lot_id')->references('id')->on('lots')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('stock_history_type_id')->references('id')->on('stock_history_types')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_histories');
    }
}
