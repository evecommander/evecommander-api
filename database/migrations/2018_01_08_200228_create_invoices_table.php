<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('issuer_id')->index();
            $table->string('issuer_type')->index();
            $table->uuid('recipient_id')->index();
            $table->string('recipient_type')->index();
            $table->string('title');
            $table->enum('status', ['pending', 'fulfilled', 'overdue'])->index();
            $table->decimal('total', 20);
            $table->dateTime('due_date');
            $table->dateTime('hard_due_date');
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
        Schema::dropIfExists('invoices');
    }
}
