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

        DB::statement("UPDATE `voters` SET `county` = IF( LENGTH(`precinct_number`) < 6, SUBSTR(`precinct_number`,1,1), SUBSTR(`precinct_number`,1,2))");
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
