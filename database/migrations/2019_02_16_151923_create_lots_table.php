<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('location_id')->comment('拠点ID');
            $table->unsignedInteger('brand_id')->comment('ブランドID');
            $table->string('lot_number')->comment('ロットナンバー');
            $table->string('name')->comment('名称');
            $table->string('jan_code')->comment('JANコード');
            $table->date('expiration_date')->comment('賞味期限')->nullable();
            $table->timestamp('ordered_at')->comment('発注日');
            $table->boolean('is_ten_days_notation')->comment('発注日時期表記フラグ')->nullable();
            $table->timestamps();

            $table->foreign('location_id')->references('id')->on('locations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lots');
    }
}
