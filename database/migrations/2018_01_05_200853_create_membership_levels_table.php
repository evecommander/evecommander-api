<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembershipLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership_levels', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('owner_id')->index();
            $table->string('owner_type')->index();
            $table->string('name');
            $table->text('description');
            $table->decimal('dues', 20);
            $table->enum('dues_structure', ['per_day', 'per_week', 'per_month', 'per_quarter', 'per_half', 'per_year', 'upon_joining']);
            $table->uuid('created_by');
            $table->uuid('last_updated_by');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('characters');
            $table->foreign('last_updated_by')->references('id')->on('characters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('membership_levels');
    }
}
