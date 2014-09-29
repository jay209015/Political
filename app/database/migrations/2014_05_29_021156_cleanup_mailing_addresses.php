<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


/**
 * Class CleanupMailingAddresses
 */
class CleanupMailingAddresses extends Migration {
    /**
     * Number of records to process at a time
     * @var int
     */
    private $batch_size = 200;

    /**
     * Number of records to skip
     * @var int
     */
    private $offset = 0;


    /**
     * Grab voters by batch
     * @return mixed
     */
    public function getBatch(){
        $Voters = Voter::where('mailing_street_address_1', '=', '')
            ->skip($this->offset)
            ->take($this->batch_size)
            ->get();

        $this->offset += $this->batch_size;

        return ($Voters->count() > 0)? $Voters: false;
    }

	/**
	 * Set the mailing address to the
     * registration address if mailing
     * address is blank
	 *
	 * @return void
	 */
	public function up()
	{
        // Fix the length of the address column
        DB::statement('ALTER TABLE voters MODIFY mailing_street_address_1 VARCHAR(255)');

		// Find all voters with blank mailing address
        DB::disableQueryLog();
        while($Voters = $this->getBatch()){
            echo "Processed: {$this->offset} records.\n";
           // print_r($Voters);
            foreach($Voters as $Voter){
                $Voter->mailing_street_address_1 = $Voter->street_house_num;
                $Voter->mailing_street_address_1 .= ' '.$Voter->street_direction;
                $Voter->mailing_street_address_1 .= ' '.$Voter->street_name;
                $Voter->mailing_street_address_1 .= ' '.$Voter->street_type;
                $Voter->mailing_street_address_2 = $Voter->building_num;
                $Voter->mailing_address_city = $Voter->city;
                $Voter->mailing_address_state = 'OK';
                $Voter->mailing_address_zip_code = $Voter->zip_code;
                $Voter->Save();
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
	}

}
