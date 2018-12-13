<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSquadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('squads', function (Blueprint $table) {
            $table->uuid('id');
            $table->unsignedBigInteger('api_id');
            $table->uuid('wing_id');
            $table->string('name');
            $table->softDeletes();

            // Add Keys
            $table->primary('id');
            $table->foreign('wing_id')->references('id')->on('wings');
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
        Schema::dropIfExists('squads');
    }
}
