<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHandbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('handbooks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organization_id')->index();
            $table->string('organization_type')->index();
            $table->unsignedInteger('order')->nullable()->index();
            $table->string('title');
            $table->text('description');
            $table->longText('content');
            $table->uuid('created_by');
            $table->uuid('last_updated_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('characters');
            $table->foreign('last_updated_by')->references('id')->on('characters');
        });

        // add trigger to new table
        \Illuminate\Support\Facades\DB::statement('CREATE TRIGGER handbooks_updated_at_modtime 
            BEFORE UPDATE ON handbooks FOR EACH ROW EXECUTE PROCEDURE update_updated_at_column();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('handbooks');
    }
}
