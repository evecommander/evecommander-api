<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReplacementClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replacement_claims', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code', 20);
            $table->uuid('character_id');
            $table->uuid('organization_id')->index();
            $table->string('organization_type')->index();
            $table->uuid('fitting_id');
            $table->unsignedInteger('killmail_id');
            $table->string('killmail_hash');
            $table->decimal('total', 20);
            $table->enum('status', ['pending', 'contested', 'closed', 'payed', 'accepted'])->index();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->uuid('last_updated_by')->index();

            $table->foreign('character_id')->references('id')->on('characters');
            $table->foreign('fitting_id')->references('id')->on('fittings');
            $table->foreign('last_updated_by')->references('id')->on('characters');
        });

        // add trigger to new table
        \Illuminate\Support\Facades\DB::statement('CREATE TRIGGER replacement_claims_updated_at_modtime 
            BEFORE UPDATE ON replacement_claims FOR EACH ROW EXECUTE PROCEDURE update_updated_at_column();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replacement_claims');
    }
}
