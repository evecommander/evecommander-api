<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctrineFittingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctrine_fitting', function (Blueprint $table) {
            $table->uuid('doctrine_id');
            $table->uuid('fitting_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->primary(['doctrine_id', 'fitting_id']);
            $table->foreign('doctrine_id')->references('id')->on('doctrines');
            $table->foreign('fitting_id')->references('id')->on('fittings');
        });

        // add trigger to new table
        \Illuminate\Support\Facades\DB::statement('CREATE TRIGGER doctrine_fitting_updated_at_modtime 
            BEFORE UPDATE ON doctrine_fitting FOR EACH ROW EXECUTE PROCEDURE update_updated_at_column();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctrine_fitting');
    }
}
