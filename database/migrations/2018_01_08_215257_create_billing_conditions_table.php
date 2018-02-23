<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->uuid('id');
            $table->morphs('owner');
            $table->string('name');
            $table->text('description');
            $table->enum('type', ['joining', 'exit', 'min_members', 'max_members', 'min_amount', 'max_amount']);
            $table->unsignedInteger('quantity')->nullable();
            $table->timestamps();

            $table->primary('id');
        });
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
