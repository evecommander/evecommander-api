<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->primary(['membership_level_id', 'permission_id']);
            $table->foreign('membership_level_id')->references('id')->on('membership_levels');
            $table->foreign('permission_id')->references('id')->on('permissions');
        });

        // add trigger to new table
        \Illuminate\Support\Facades\DB::statement('CREATE TRIGGER membership_level_permission_updated_at_modtime 
            BEFORE UPDATE ON membership_level_permission FOR EACH ROW EXECUTE PROCEDURE update_updated_at_column();');
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
