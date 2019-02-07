<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_stock_id')->comment('商品在庫ID');
            $table->unsignedInteger('location_id')->comment('拠点ID');
            $table->integer('quantity')->comment('数量');
            $table->text('delivery')->comment('納期')->nullable();
            $table->text('note')->comment('備考')->nullable();
            $table->timestamp('order_at')->comment('発注日')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();

            $table->foreign('product_stock_id')->references('id')->on('product_stocks')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('order_histories');
    }
}
