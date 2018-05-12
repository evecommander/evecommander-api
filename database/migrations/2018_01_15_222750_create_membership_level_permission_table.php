<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembershipLevelPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membership_level_permission', function (Blueprint $table) {
            $table->uuid('membership_level_id');
            $table->uuid('permission_id');
            $table->timestamps();

            $table->primary(['membership_level_id', 'permission_id']);
            $table->foreign('membership_level_id')->references('id')->on('membership_levels');
            $table->foreign('permission_id')->references('id')->on('permissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('membership_level_permission');
    }
}
