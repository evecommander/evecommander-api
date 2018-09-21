<?php

use Illuminate\Database\Migrations\Migration;

class CreateUpdatedAtFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement('
        CREATE OR REPLACE FUNCTION update_updated_at_column() RETURNS trigger
            LANGUAGE plpgsql
            AS $$
          BEGIN
            NEW.updated_at = NOW();
            RETURN NEW;
          END;
        $$;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::statement('DROP FUNCTION IF EXISTS update_updated_at_column;');
    }
}
