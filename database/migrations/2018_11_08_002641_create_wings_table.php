<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('wings', function (Blueprint $table) {
            $table->uuid('id');
            $table->unsignedBigInteger('api_id');
            $table->uuid('fleet_id');
            $table->string('name');
            $table->softDeletes();

            // Add Keys
            $table->primary('id');
            $table->foreign('fleet_id')->references('id')->on('fleets');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wings');
    }
}
