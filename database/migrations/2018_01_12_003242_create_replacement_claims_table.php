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
            $table->unsignedInteger('character_id')->index();
            $table->morphs('organization');
            $table->unsignedInteger('fitting_id')->index();
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
