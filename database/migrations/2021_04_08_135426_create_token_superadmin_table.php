<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokenSuperadminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('token_superadmin', function (Blueprint $table) {
            $table->string('ID')->primary();
            $table->integer('SuperadminID');
            $table->string('DeviceType');
            $table->integer('CreatedAt');
        });

        Schema::create('token_superadmin_deleted', function (Blueprint $table) {
            $table->bigInteger('DeletedTimestamp');
            $table->string('TokenID');
            $table->integer('SuperadminID');
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
        Schema::dropIfExists('token_superadmin');
        Schema::dropIfExists('token_superadmin_deleted');

    }
}
