<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('code', 20);
            $table->uuid('issuer_id')->index();
            $table->string('issuer_type')->index();
            $table->uuid('recipient_id')->index();
            $table->string('recipient_type')->index();
            $table->string('title');
            $table->enum('status', ['pending', 'fulfilled', 'overdue'])->index();
            $table->decimal('total', 20);
            $table->dateTime('due_date');
            $table->dateTime('hard_due_date');
            $table->uuid('last_updated_by')->index();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('last_updated_by')->references('id')->on('characters');
        });

        // add trigger to new table
        \Illuminate\Support\Facades\DB::statement('CREATE TRIGGER invoices_updated_at_modtime 
            BEFORE UPDATE ON invoices FOR EACH ROW EXECUTE PROCEDURE update_updated_at_column();');
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
