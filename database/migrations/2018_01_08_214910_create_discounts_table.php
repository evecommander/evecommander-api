<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('owner_id')->index();
            $table->string('owner_type')->index();
            $table->uuid('billing_condition_id')->nullable();
            $table->enum('amount_type', ['fixed', 'percent', 'per_member']);
            $table->decimal('amount', 20)->comment('If amount_type is fixed, amount is in ISK; If percent, amount is a percentage; If per_member, amount is fixed but multiplied by how many members the target has.');
            $table->timestamps();

            $table->foreign('billing_condition_id')->references('id')->on('billing_conditions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts');
    }
}
