<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin', function (Blueprint $table) {
            $table->string('designation', 100)->after('last_name');
            $table->string('contact_no', 20)->after('designation');
            $table->boolean('status_on')->after('contact_no')->default(0)->comment(' 0 = offline,1 = online');;
            $table->string('emergency_name', 191)->after('is_term_accept')->nullable();
            $table->string('emergency_relationship', 191)->after('emergency_name')->nullable();
            $table->string('emergency_contact', 20)->after('emergency_relationship')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin', function (Blueprint $table) {
            $table->dropColumn('designation');
            $table->dropColumn('contact_no');
            $table->dropColumn('status');
            $table->dropColumn('emergency_name');
            $table->dropColumn('emergency_relationship');
            $table->dropColumn('emergency_contact');
        });
    }
}
