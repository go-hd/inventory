<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_lot_id')->comment('親ロットID');
            $table->unsignedInteger('child_lot_id')->comment('子ロットID');
            $table->text('note')->comment('備考')->nullable();
            $table->timestamps();

            $table->foreign('parent_lot_id')->references('id')->on('lots')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('child_lot_id')->references('id')->on('lots')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
