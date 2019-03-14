<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id')->comment('会社ID');
            $table->string('name')->comment('名称');
            $table->unsignedInteger('location_type_id')->comment('拠点種別ID');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('location_type_id')->references('id')->on('location_types')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->foreign('main_location_id')->references('id')->on('locations')->onUpdate('cascade')->onDelete('cascade');
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
            $table->dropForeign('companies_main_location_id_foreign');
        });
        Schema::dropIfExists('locations');
    }
}
