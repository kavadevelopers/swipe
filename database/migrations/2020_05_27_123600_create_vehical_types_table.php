<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicalTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehical_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vehical_name')->unique();
            $table->string('description')->nullabel();
            $table->string('vehical_img')->nullabel();
            $table->string('status')->nullabel();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehical_types');
    }
}
