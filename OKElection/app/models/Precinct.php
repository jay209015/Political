<?php

/**
 * Represents precinct/district information.
 *
 * @author   Andre Patterson <apatterson@printplace.com>
 */
class Precinct extends Eloquent {

    /**
     * Retrieve the Congressional District
     *
     * @return integer
     */
    public function getCongressionalDistrict() {
        return $this->congressional_district;
    }

    /**
     * Retrieve the State Senate District
     *
     * @return integer
     */
    public function getStateSenateDistrict() {
        return $this->state_senate_district;
    }

    /**
     * Retrieve the State House District
     *
     * @return integer
     */
    public function getStateHouseDistrict() {
        return $this->state_house_district;
    }

    /**
     * Retrieve the County Commissioner District
     *
     * @return integer
     */
    public function getCountyCommissionerDistrict() {
        return $this->county_commissioner_district;
    }

    /**
     * Retrieve the Polling Place
     *
     * @return string
     */
    public function getPollingPlace() {
        return $this->polling_place;
    }

    /**
     * One-to-Many relationship
     * A district/precinct may have an arbitrary amount of voters.
     */
	public function voter() {
		return $this->hasMany('Voter');
	}
}