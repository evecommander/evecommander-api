<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('character_id');
            $table->uuid('organization_id')->index();
            $table->string('organization_type')->index();
            $table->string('fitting_id');
            $table->unsignedInteger('killmail_id');
            $table->string('killmail_hash');
            $table->decimal('total', 20);
            $table->enum('status', ['pending', 'contested', 'closed', 'payed'])->index();
            $table->timestamps();

            $table->foreign('character_id')->references('id')->on('characters');
            $table->foreign('fitting_id')->references('id')->on('fittings');
        });
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
