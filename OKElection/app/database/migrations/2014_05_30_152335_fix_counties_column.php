<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixCountiesColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('voters', function($table)
        {
            $table->dropColumn('county');
            // Add the county column with index
            $table->integer('county');
            $table->index('county');

            // Set the values for the counties to the first 2 digits of the precinct
            DB::statement("UPDATE `voters` SET `county` = IF( LENGTH(`precinct_number`) < 6, SUBSTR(`precinct_number`,1,1), SUBSTR(`precinct_number`,1,2))");
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        // Drop the county column and index
        Schema::table('voters', function($table)
        {
            $table->dropColumn('county');
            $table->dropIndex('county');
        });
	}

}
