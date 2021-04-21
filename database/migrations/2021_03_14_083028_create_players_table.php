<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('PlayerGameName');
            $table->string('PlayerName');
            $table->string('Country');
            $table->date('Birthdate');
            $table->string('AvatarPlayer');
            $table->string('InGameRole');
            $table->integer('Team');
            $table->integer('GameType');
            $table->enum('StatusPlayer',['ACTIVE','NON ACTIVE']);
            $table->integer('SocialMediaPlayer');
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
        Schema::dropIfExists('players');
    }
}
