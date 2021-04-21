<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTokenSuperadmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('token_superadmin', function (Blueprint $table) {
            $table->renameColumn('SuperadminID', 'SuperadminUsername');
        });
        
        Schema::table('token_superadmin', function (Blueprint $table) {
            $table->string('SuperadminUsername')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('token_superadmin', function (Blueprint $table) {
            $table->renameColumn('SuperadminUsername', 'SuperadminID');
        });
    }
}
