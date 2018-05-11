<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctrinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctrines', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('owner_id');
            $table->string('owner_type');
            $table->string('name');
            $table->text('description');
            $table->unsignedInteger('priority');
            $table->uuid('added_by');
            $table->uuid('last_updated_by');
            $table->timestamps();

            $table->primary('id');
            $table->foreign('added_by')->references('id')->on('characters');
            $table->foreign('last_updated_by')->references('id')->on('characters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctrines');
    }
}
