<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctrineFittingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctrine_fitting', function (Blueprint $table) {
            $table->uuid('doctrine_id');
            $table->uuid('fitting_id');
            $table->timestamps();

            $table->primary(['doctrine_id', 'fitting_id']);
            $table->foreign('doctrine_id')->references('id')->on('doctrines');
            $table->foreign('fitting_id')->references('id')->on('fittings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctrine_fitting');
    }
}
