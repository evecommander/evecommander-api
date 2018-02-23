<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorporationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporations', function (Blueprint $table) {
            $table->uuid('id');
            $table->unsignedInteger('api_id');
            $table->string('name');
            $table->unsignedInteger('default_membership_level')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('corporations');
    }
}
