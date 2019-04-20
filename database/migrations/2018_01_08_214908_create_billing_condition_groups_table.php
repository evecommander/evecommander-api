<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingConditionGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_condition_groups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('type', ['and', 'or']);
            $table->uuid('organization_id')->index();
            $table->string('organization_type')->index();
            $table->uuid('parent_group_id')->nullable()->index();
            $table->timestamps();
        });

        // add trigger to new table
        \Illuminate\Support\Facades\DB::statement('CREATE TRIGGER billing_condition_groups_updated_at_modtime 
            BEFORE UPDATE ON billing_condition_groups FOR EACH ROW EXECUTE PROCEDURE update_updated_at_column();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billing_condition_groups');
    }
}
