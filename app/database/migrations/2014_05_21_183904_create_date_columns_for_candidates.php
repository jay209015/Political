<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDateColumnsForCandidates extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Fix Date Format
        if(
            DB::statement("
            UPDATE candidates
            SET
                elec_date = IF( LENGTH(elec_date) >= 9, CONCAT(
                    REVERSE(SUBSTR(REVERSE(elec_date), 1, 4)), '-',
                    LPAD(REPLACE (SUBSTR(elec_date FROM 1 FOR 2),'/',''),2,'0'), '-',
                    LPAD(REPLACE(REVERSE(SUBSTR(REVERSE(elec_date), 6, 2)), '/', ''), 2, '0')
                ), '0000-00-00'),
                prim_or_runoff_date = IF( LENGTH(prim_or_runoff_date) >= 9, CONCAT(
                    REVERSE(SUBSTR(REVERSE(prim_or_runoff_date), 1, 4)), '-',
                    LPAD(REPLACE (SUBSTR(prim_or_runoff_date FROM 1 FOR 2),'/',''),2,'0'), '-',
                    LPAD(REPLACE(REVERSE(SUBSTR(REVERSE(prim_or_runoff_date), 6, 2)), '/', ''), 2, '0')
                ), '0000-00-00'),
                `date` = IF( LENGTH(`date`) >= 9, CONCAT(
                    REVERSE(SUBSTR(REVERSE(`date`), 1, 4)), '-',
                    LPAD(REPLACE (SUBSTR(`date` FROM 1 FOR 2),'/',''),2,'0'), '-',
                    LPAD(REPLACE(REVERSE(SUBSTR(REVERSE(`date`), 6, 2)), '/', ''), 2, '0')
                ), '0000-00-00')
            ")
        ){
           if(
            DB::statement("ALTER TABLE `okelection`.`candidates`
            CHANGE COLUMN `prim_or_runoff_date` `prim_or_runoff_date` date NOT NULL,
            CHANGE COLUMN `elec_date` `elec_date` date NOT NULL,
            CHANGE COLUMN `date` `date` date NOT NULL;")
           ){

           }else{

           }
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
        echo 'Downgrading';
	}

}
