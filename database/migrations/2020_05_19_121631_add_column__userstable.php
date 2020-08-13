<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUserstable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('citizenship', 50)->after('country_code')->nullable();
            $table->date('dob')->after('citizenship')->nullable();
            $table->tinyInteger('status')->after('dob')->default(0)->comment(' 0 = pending,1 = approve, 2 = reject')->nullable();
            $table->string('activation_code',50)->after('status')->nullable();
            $table->tinyInteger('payment_status')->after('dob')->default(0)->comment(' 0 = pending,1 = paid, 2 = reject');
            $table->integer('admin_id')->unsigned()->nullable()->default(null);
            $table->foreign('admin_id')->references('id')->on('admin')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('citizenship');
            $table->dropColumn('dob');
            $table->dropColumn('status');
            $table->dropColumn('activation_code');
            $table->dropColumn('admin_id');
            $table->dropColumn('payment_status');
        });
    }
}
