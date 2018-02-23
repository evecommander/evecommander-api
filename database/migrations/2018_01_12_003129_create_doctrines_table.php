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
            $table->morphs('owner');
            $table->string('name');
            $table->text('description');
            $table->unsignedInteger('priority');
            $table->unsignedInteger('added_by');
            $table->unsignedInteger('last_updated_by');
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
        Schema::dropIfExists('doctrines');
    }
}
