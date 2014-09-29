<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountyToVotersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Add the county column with index
        Schema::table('voters', function($table){
            $table->integer('county');
            $table->index('county');
        });

        // Set the values for the counties to the first 2 digits of the precinct
        DB::statement("UPDATE `voters` SET `county` = SUBSTR(`precinct_number`,1,2)");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Drop the county column
        Schema::table('voters', function($table)
        {
            $table->dropColumn('county');
        });
	}

}
