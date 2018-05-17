<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->uuid('id')->primary();
            $table->uuid('owner_id')->index();
            $table->string('owner_type')->index();
            $table->string('name');
            $table->text('description');
            $table->unsignedInteger('priority');
            $table->uuid('created_by');
            $table->uuid('last_updated_by');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('characters');
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
