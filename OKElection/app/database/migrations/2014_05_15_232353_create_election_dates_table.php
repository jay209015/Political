<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectionDatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('elections', function($table){
            $table->increments('id');
            $table->date('election_date');
            $table->integer('voters');

            $table->index('election_date');
            $table->index('voters');
        });

        DB::statement('INSERT INTO elections SELECT 0, election_date, COUNT(*) as `voters` FROM histories GROUP BY election_date ORDER BY election_date ASC');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
        Schema::drop('elections');
	}

}
