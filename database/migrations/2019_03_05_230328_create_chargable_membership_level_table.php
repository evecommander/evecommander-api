<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChargableMembershipLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chargable_membership_level', function (Blueprint $table) {
            $table->uuid('chargable_id');
            $table->string('chargable_type');
            $table->uuid('membership_level_id');
            $table->timestamps();

            $table->primary(['chargable_id', 'chargable_type', 'membership_level_id']);
            $table->foreign('membership_level_id')->references('id')->on('membership_levels');
        });

        // add trigger to new table
        \Illuminate\Support\Facades\DB::statement('CREATE TRIGGER chargable_membership_level_updated_at_modtime 
            BEFORE UPDATE ON chargable_membership_level FOR EACH ROW EXECUTE PROCEDURE update_updated_at_column();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chargable_membership_level');
    }
}
