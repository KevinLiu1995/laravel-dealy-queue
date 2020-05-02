<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToChoujiangRecordTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chou_jiang_records', function (Blueprint $table) {
            //
            $table->string('email')->after('prize')->comment('邮箱');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chou_jiang_records', function (Blueprint $table) {
            //
            $table->removeColumn('email');
        });
    }
}
