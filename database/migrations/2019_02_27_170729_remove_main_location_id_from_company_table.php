<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveMainLocationIdFromCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign('companies_main_location_id_foreign');
            $table->dropColumn('main_location_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('level')->after('remember_token')->comment('権限レベル')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->unsignedInteger('main_location_id')->after('name')->comment('メイン拠点ID')->nullable();
            $table->foreign('main_location_id')->references('id')->on('locations')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('level');
        });
    }
}
