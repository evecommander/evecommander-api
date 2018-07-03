<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFleetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fleets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('fleet_type_id');
            $table->uuid('organization_id')->index();
            $table->string('organization_type')->index();
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['pending', 'standby', 'form-up', 'in-progress', 'completed', 'cancelled'])->default('pending');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->uuid('created_by');
            $table->uuid('last_updated_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('fleet_type_id')->references('id')->on('fleet_types');
            $table->foreign('created_by')->references('id')->on('characters');
            $table->foreign('last_updated_by')->references('id')->on('characters');
        });

        // add trigger to new table
        \Illuminate\Support\Facades\DB::statement('CREATE TRIGGER fleets_updated_at_modtime 
            BEFORE UPDATE ON fleets FOR EACH ROW EXECUTE PROCEDURE update_updated_at_column();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fleets');
    }
}
