<?php

use App\FleetMember;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFleetMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('fleet_members', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('fleet_id');
            $table->uuid('wing_id');
            $table->uuid('squad_id');
            $table->unsignedInteger('character_api_id')->index();
            $table->uuid('character_id')->nullable();
            $table->dateTime('join_time');
            $table->enum('role', [
                FleetMember::ROLE_FLEET_COMMANDER,
                FleetMember::ROLE_WING_COMMANDER,
                FleetMember::ROLE_SQUAD_COMMANDER,
                FleetMember::ROLE_SQUAD_MEMBER,
            ]);
            $table->unsignedInteger('ship_type_id')->index();
            $table->unsignedInteger('solar_system_id')->index();
            $table->unsignedBigInteger('station_id')->index();
            $table->boolean('takes_fleet_warp');
            $table->softDeletes();

            // Add Keys
            $table->primary('id');
            $table->foreign('fleet_id')->references('id')->on('fleets');
            $table->foreign('character_id')->references('id')->on('characters');
            $table->foreign('squad_id')->references('id')->on('squads');
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
        Schema::dropIfExists('fleet_members');
    }
}
