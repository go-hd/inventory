<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsMoveFromMaterialToStockMovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_moves', function (Blueprint $table) {
            $table->boolean('is_from_material')->nullable()->default(false)->comment('材料から生産フラグ')->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_moves', function (Blueprint $table) {
            $table->dropColumn('is_from_material');
        });
    }
}
