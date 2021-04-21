<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePubgmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pubgm', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->integer('GamerID');
            $table->string('StatisticsID')->nullable();
            $table->string('InGameName')->nullable();
            $table->string('PubgmID')->nullable();
            $table->string('BestGameplay')->nullable();
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
        Schema::dropIfExists('pubgm');
    }
}
