<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatisticPubgmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistic_pubgm', function (Blueprint $table) {
            $table->bigInteger('ID');
            $table->enum('Type', ['SOLO', 'DUO', 'SQUAD'])->nullable();
            $table->enum('Mode', ['TPP', 'FPP'])->nullable();
            $table->integer('Season')->nullable();
            $table->enum('server', ['ASIA','KRJP','NA'])->nullable();
            $table->string('FileTierOverview')->nullable();
            $table->string('FileStatistic')->nullable();
            $table->float('RatioKD')->nullable();
            $table->integer('MatchesPlayed')->nullable();
            $table->integer('Kills')->nullable();
            $table->integer('CreatedAt')->nullable();
            $table->integer('ModifyAt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statistic_pubgm');
    }
}
