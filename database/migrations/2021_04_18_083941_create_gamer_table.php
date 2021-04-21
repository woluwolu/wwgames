<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gamer', function (Blueprint $table) {
            $table->bigIncrements('ID');
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('Email');
            $table->string('Username');
            $table->string('Password');
            $table->string('Discord');
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
        Schema::dropIfExists('gamer');
    }
}
