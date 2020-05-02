<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToChoujiangRecordTable extends Migration
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
            $table->string('name')->after('email');
            $table->string('value')->after('name');
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
            $table->removeColumn('name');
            $table->removeColumn('value');
        });
    }
}
