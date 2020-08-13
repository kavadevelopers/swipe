<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromocodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promocodes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('created_by')->nullable()->default(null);
            $table->boolean('status')->default(true);
            $table->string('promo_code')->unique();
            $table->boolean('usable')->default(true);
            $table->integer('count_limit')->nullable()->default(null);
            $table->decimal('amount', 8, 2)->nullable()->default(null);
            $table->string('promo_type')->nullable()->default(null);
            $table->string('usage_type')->nullable()->default(null);
            $table->dateTime('start_date')->nullable()->default(null);
            $table->dateTime('end_date')->nullable()->default(null);
            $table->text('message')->nullable()->default(null);
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
        Schema::dropIfExists('promocodes');
    }
}
