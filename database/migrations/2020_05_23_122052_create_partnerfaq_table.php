<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerfaqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partnerfaqs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('question')->nullable();
            $table->text('answer')->nullable();
            $table->bigInteger('upvote')->default(0);
            $table->bigInteger('downvote')->default(0);
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
        Schema::dropIfExists('partnerfaqs');
    }
}
