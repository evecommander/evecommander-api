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
            $table->uuid('organization_id')->index();
            $table->string('organization_type')->index();
            $table->uuid('conditional_id')->nullable()->index();
            $table->string('conditional_type')->nullable()->index();
            $table->uuid('membership_level_id')->nullable()->index();
            $table->string('name');
            $table->text('description');
            $table->enum('amount_type', ['fixed', 'percent', 'per_member']);
            $table->decimal('amount', 20)->comment('If amount_type is fixed, amount is in ISK; If percent, amount is a percentage; If per_member, amount is fixed but multiplied by how many members the target has.');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('membership_level_id')->references('id')->on('membership_levels');
        });

        // add trigger to new table
        \Illuminate\Support\Facades\DB::statement('CREATE TRIGGER discounts_updated_at_modtime 
            BEFORE UPDATE ON discounts FOR EACH ROW EXECUTE PROCEDURE update_updated_at_column();');
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
