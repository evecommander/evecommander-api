<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFittingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fittings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('doctrine_id');
            $table->uuid('organization_id')->index();
            $table->string('organization_type')->index();
            $table->string('name');
            $table->text('description');
            $table->unsignedInteger('api_id');
            $table->timestamps();

            $table->foreign('doctrine_id')->references('id')->on('doctrines');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fittings');
    }
}
