<?php

/**
 * Represents an Oklahoman voter's registration information as well as how they voted, political affiliation, etc.
 *
 * @author   Andre Patterson <apatterson@printplace.com>
 */
class Voter extends Eloquent {

    /**
     * We don't need timestamps in our table.
     *
     * @var string
     */
    protected $timestamps = 'false';

    /**
     * Retrieve the voter's first name
     *
     * @return string
     */
    public function getFirstName() {
        return $this->first_name;
    }

    /**
     * Retrieve the voter's middle name
     *
     * @return string
     */
    public function getMiddleName() {
        return $this->middle_name;
    }

    /**
     * Retrieve the voter's last name
     *
     * @return string
     */
    public function getLastName() {
        return $this->last_name;
    }

    /**
     * Retrieve the voter's suffix e.g. Jr, Sr, II, etc.
     *
     * @return string
     */
    public function getSuffix() {
        return $this->suffix;
    }

    /**
     * Retrieve the voter's political affiliation e.g. DEM, REP, etc.
     *
     * @return string
     */
    public function getPoliticalAffiliation() {
        return $this->political_affiliation;
    }

    /**
     * Retrieve the voter's status e.g. (A) active, (I) inactive
     *
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Retrieve the voter's street house number
     *
     * @return integer
     */
    public function getStreetHouseNum() {
        return $this->street_house_num;
    }

    /**
     * Retrieve the voter's street direction e.g. E, SW, NE, etc.
     *
     * @return string
     */
    public function getStreetDirection() {
        return $this->street_direction;
    }

    /**
     * Retrieve the voter's street name
     *
     * @return string
     */
    public function getStreetName() {
        return $this->street_name;
    }

    /**
     * Retrieve the voter's street type e.g. Ave, Blvd, St, etc.
     *
     * @return string
     */
    public function getStreetType() {
        return $this->street_type;
    }

    /**
     * Retrieve the voter's building number e.g. Apartment or Suite #, etc.
     *
     * @return integer
     */
    public function getBuildingNumber() {
        return $this->building_num;
    }

    /**
     * Retrieve the voter's city
     *
     * @return string
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * Retrieve the voter's zip code
     *
     * @return integer
     */
    public function getZipCode() {
        return $this->zip_code;
    }

    /**
     * Retrieve the voter's birth date in CCYYMMDD format e.g. July 15, 1990 would be 19900715
     *
     * @return integer
     */
    public function getBirthDate() {
        return $this->birth_date;
    }

    /**
     * Retrieve the voter's registration date in CCYYMMDD format e.g. July 15, 1990 would be 19900715
     *
     * @return integer
     */
    public function getRegistrationDate() {
        return $this->registration_date;
    }

    /**
     * Retrieve the voter's mailing street address line 1 (Free form 30-character address line)
     *
     * @return string
     */
    public function getMailingStreetAddress1() {
        return $this->mailing_street_address_1;
    }

    /**
     * Retrieve the voter's mailing street address line 2 (Free form 30-character address line)
     *
     * @return string
     */
    public function getMailingStreetAddress2() {
        return $this->mailing_street_address_2;
    }

    /**
     * Retrieve the voter's mailing address city
     *
     * @return string
     */
    public function getMailingAddressCity() {
        return $this->mailing_address_city;
    }

    /**
     * Retrieve the voter's mailing address state
     *
     * @return string
     */
    public function getMailingAddressState() {
        return $this->mailing_address_state;
    }

    /**
     * Retrieve the voter's mailing address zip code
     *
     * @return integer
     */
    public function getMailingAddressZipCode() {
        return $this->mailing_address_zip_code;
    }

	/**
     * Inverse of One-to-Many relationship
	 * An arbitrary amount of voters may belong to one district/precinct.
	 */
	public function precinct() {
		return $this->belongsTo('Precinct');
	}
}