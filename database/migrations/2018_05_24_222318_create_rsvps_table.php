<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRsvpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rsvps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('fleet_id');
            $table->uuid('character_id');
            $table->enum('response', [1, 0, -1]);
            $table->text('notes');
            $table->boolean('confirmed');
            $table->text('confirmation_notes');
            $table->timestamps();

            $table->foreign('fleet_id')->references('id')->on('fleets');
            $table->foreign('character_id')->references('id')->on('characters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rsvps');
    }
}
