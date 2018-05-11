<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->uuid('id');
            $table->uuid('leader_character_id');
            $table->string('name');
            $table->text('description');
            $table->string('logo');
            $table->json('settings');
            $table->timestamps();

            $table->primary('id');
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
