<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyServerInTableStatisticPubgm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('statistic_pubgm', function (Blueprint $table) {
            $table->renameColumn('server', 'Server');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('statistic_pubgm', function (Blueprint $table) {
            $table->renameColumn('server', 'Server');
        });
    }
}
