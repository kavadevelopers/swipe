<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnMycarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('my_cars', function (Blueprint $table) {
            $table->decimal('user_price', 20, 2)->default(0);
            $table->decimal('partner_price', 20, 2)->default(0);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('my_cars', function (Blueprint $table) {
            $table->dropColumn('user_price');
            $table->dropColumn('partner_price');
        });
    }
}
