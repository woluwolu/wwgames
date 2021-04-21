<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokenGamerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('token_gamer', function (Blueprint $table) {
            $table->string('ID')->primary();
            $table->integer('GamerID');
            $table->string('DeviceType');
            $table->integer('CreatedAt');
        });

        Schema::create('token_gamer_deleted', function (Blueprint $table) {
            $table->bigInteger('DeletedTimestamp');
            $table->string('TokenID');
            $table->integer('GamerID');
            $table->string('DeviceType');
            $table->integer('CreatedAt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('token_gamer');
        Schema::dropIfExists('token_gamer_deleted');    
    }
}
