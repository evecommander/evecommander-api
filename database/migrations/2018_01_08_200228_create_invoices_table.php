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
            $table->uuid('id');
            $table->uuid('issuer_id');
            $table->string('issuer_type');
            $table->uuid('recipient_id');
            $table->string('recipient_type');
            $table->string('title');
            $table->enum('status', ['pending', 'fulfilled', 'overdue']);
            $table->decimal('total', 20);
            $table->dateTime('due_date');
            $table->dateTime('hard_due_date');
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
        Schema::dropIfExists('invoices');
    }
}
