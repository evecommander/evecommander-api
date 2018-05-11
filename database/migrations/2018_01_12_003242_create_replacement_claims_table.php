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
            $table->uuid('id');
            $table->string('character_id')->index();
            $table->uuid('organization_id');
            $table->string('organization_type');
            $table->string('fitting_id')->index();
            $table->unsignedInteger('killmail_id');
            $table->string('killmail_hash');
            $table->decimal('total', 20);
            $table->enum('status', ['pending', 'contested', 'closed', 'payed']);
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
        Schema::dropIfExists('replacement_claims');
    }
}
