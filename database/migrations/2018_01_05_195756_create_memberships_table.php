<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organization_id')->index();
            $table->string('organization_type')->index();
            $table->uuid('member_id')->index();
            $table->string('member_type')->index();
            $table->uuid('membership_level_id');
            $table->text('notes');
            $table->uuid('created_by');
            $table->uuid('last_updated_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('membership_level_id')->references('id')->on('membership_levels');
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
        Schema::dropIfExists('memberships');
    }
}
