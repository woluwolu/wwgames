<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyGamerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gamer', function (Blueprint $table) {
            $table->string('Discord')->nullable()->change();
            $table->string('EmailVerificationCode')->nullable();
            $table->string('HasVerifiedEmail')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gamer', function (Blueprint $table) {
            $table->dropColumn('Discord')->nullable()->change();
            $table->dropIfExists('EmailVerificationCode')->nullable();
            $table->dropIfExists('HasVerifiedEmail')->nullable();
        });
    }
}
