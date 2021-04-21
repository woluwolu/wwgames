<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_players', function (Blueprint $table) {
            $table->id();
            $table->integer('PlayerID');
            $table->integer('GameID');
            $table->integer('OldTeam');
            $table->integer('NewTeam');
            $table->date('TransferDate');
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
        Schema::dropIfExists('transfer_players');
    }
}
