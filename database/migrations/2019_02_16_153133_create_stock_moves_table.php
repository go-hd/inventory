<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockMovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_moves', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('shipping_id')->comment('出庫ID（在庫履歴）');
            $table->unsignedInteger('recieving_id')->comment('入庫ID（在庫履歴）');
            $table->unsignedInteger('location_id')->comment('相手拠点ID');
            $table->integer('quantity')->comment('移動個数');
            $table->timestamps();

            $table->foreign('shipping_id')->references('id')->on('stock_histories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('recieving_id')->references('id')->on('stock_histories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_moves');
    }
}
