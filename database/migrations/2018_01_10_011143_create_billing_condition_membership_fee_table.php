<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingConditionMembershipFeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_condition_membership_fee', function (Blueprint $table) {
            $table->uuid('billing_condition_id');
            $table->uuid('membership_fee_id');
            $table->unsignedInteger('order')->index();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->primary(['billing_condition_id', 'membership_fee_id']);
            $table->foreign('billing_condition_id')->references('id')->on('billing_conditions');
            $table->foreign('membership_fee_id')->references('id')->on('membership_fees');
        });

        // add trigger to new table
        \Illuminate\Support\Facades\DB::statement('CREATE TRIGGER billing_condition_membership_fee_updated_at_modtime 
            BEFORE UPDATE ON billing_condition_membership_fee FOR EACH ROW EXECUTE PROCEDURE update_updated_at_column();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billing_condition_membership_fee');
    }
}
