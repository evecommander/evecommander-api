<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlliancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alliances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedInteger('api_id');
            $table->string('name');
            $table->uuid('default_membership_level')->nullable();
            $table->json('settings');
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
        Schema::dropIfExists('alliances');
    }
}
