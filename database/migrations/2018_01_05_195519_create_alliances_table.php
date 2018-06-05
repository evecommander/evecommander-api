<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->unsignedInteger('api_id')->index();
            $table->string('name');
            $table->uuid('default_membership_level')->nullable();
            $table->jsonb('settings');
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
