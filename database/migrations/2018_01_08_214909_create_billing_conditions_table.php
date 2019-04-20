<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_conditions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('billing_condition_group_id')->index()->nullable();
            $table->uuid('organization_id')->index();
            $table->string('organization_type')->index();
            $table->string('name');
            $table->text('description');
            $table->enum('type', ['joining', 'exiting', 'min_members', 'max_members']);
            $table->unsignedInteger('quantity')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('billing_condition_group_id')->references('id')->on('billing_condition_groups');
        });

        // add trigger to new table
        \Illuminate\Support\Facades\DB::statement('CREATE TRIGGER billing_conditions_updated_at_modtime 
            BEFORE UPDATE ON billing_conditions FOR EACH ROW EXECUTE PROCEDURE update_updated_at_column();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billing_conditions');
    }
}
