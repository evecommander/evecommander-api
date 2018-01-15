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
            $table->increments('id');
            $table->morphs('owner');
            $table->string('name');
            $table->text('description');
            $table->decimal('dues', 20);
            $table->enum('dues_structure', ['per_day', 'per_week', 'per_month', 'per_quarter', 'per_half', 'per_year', 'upon_joining']);
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('last_updated_by');
            $table->timestamps();
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
