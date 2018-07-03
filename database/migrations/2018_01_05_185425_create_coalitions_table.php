<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoalitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coalitions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('leader_character_id');
            $table->string('name');
            $table->text('description');
            $table->string('logo');
            $table->uuid('default_membership_level')->nullable();
            $table->jsonb('settings');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('leader_character_id')->references('id')->on('characters');
            $table->foreign('default_membership_level')->references('id')->on('membership_levels');
        });

        // add trigger to new table
        \Illuminate\Support\Facades\DB::statement('CREATE TRIGGER coalitions_updated_at_modtime 
            BEFORE UPDATE ON coalitions FOR EACH ROW EXECUTE PROCEDURE update_updated_at_column();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coalitions');
    }
}
