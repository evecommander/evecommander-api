<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->timestamps();

            $table->primary(['billing_condition_id', 'membership_fee_id']);
            $table->foreign('billing_condition_id')->references('id')->on('billing_conditions');
            $table->foreign('membership_fee_id')->references('id')->on('membership_fees');
        });
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
