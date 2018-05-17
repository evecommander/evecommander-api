<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoalitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coalitions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('leader_character_id');
            $table->string('name');
            $table->text('description');
            $table->string('logo');
            $table->uuid('default_membership_level')->nullable();
            $table->json('settings');
            $table->timestamps();

            $table->foreign('leader_character_id')->references('id')->on('characters');
            $table->foreign('default_membership_level')->references('id')->on('membership_levels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coalitions');
    }
}
