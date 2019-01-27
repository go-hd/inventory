<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationPaletteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_palette', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('location_id')->comment('拠点ID');
            $table->unsignedInteger('palette_id')->comment('パレットID');
            $table->integer('number')->comment('数量')->nullable()->default('0');
            $table->timestamps();

            $table->foreign('location_id')->references('id')->on('locations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('palette_id')->references('id')->on('palettes')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_palette');
    }
}
