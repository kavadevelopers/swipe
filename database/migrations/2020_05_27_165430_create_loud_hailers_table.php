<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoudHailersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loud_hailers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('message');
            $table->string('send_to')->nullable()->default(null);
            $table->bigInteger('send_by');
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
        Schema::dropIfExists('loud_hailers');
    }
}
