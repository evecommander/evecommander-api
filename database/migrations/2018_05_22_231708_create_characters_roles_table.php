<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters_roles', function (Blueprint $table) {
            $table->uuid('character_id');
            $table->uuid('role_id');
            $table->timestamps();

            $table->primary(['character_id', 'role_id']);
            $table->foreign('character_id')->references('id')->on('characters');
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('characters_roles');
    }
}
