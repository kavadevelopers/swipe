<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJoinFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('join_fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullabel();
            $table->string('payment_intent')->nullabel();
            $table->string('amount')->nullabel();
            $table->string('currency')->nullabel();
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
        Schema::dropIfExists('join_fees');
    }
}
