<?php

use App\Fleet;
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
        Schema::disableForeignKeyConstraints();

        Schema::create('fleets', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('fleet_type_id');
            $table->uuid('organization_id')->index();
            $table->string('organization_type')->index();
            $table->unsignedInteger('api_id')->index()->nullable();
            $table->string('title');
            $table->text('description');
            $table->enum('status', [
                Fleet::STATUS_PENDING,
                Fleet::STATUS_STANDBY,
                Fleet::STATUS_FORM_UP,
                Fleet::STATUS_IN_PROGRESS,
                Fleet::STATUS_COMPLETED,
                Fleet::STATUS_CANCELLED
            ])->default(Fleet::STATUS_PENDING);
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->uuid('created_by');
            $table->uuid('last_updated_by')->nullable();
            $table->boolean('track_history')->default(false);
            $table->uuid('tracker_character_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->primary('id');
            $table->foreign('fleet_type_id')->references('id')->on('fleet_types');
            $table->foreign('created_by')->references('id')->on('characters');
            $table->foreign('last_updated_by')->references('id')->on('characters');
            $table->foreign('tracker_character_id')->references('id')->on('characters');
        });

        Schema::enableForeignKeyConstraints();

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
