<?php

/**
 * Represents precinct/district information.
 *
 * @author   Andre Patterson <apatterson@printplace.com>
 */
class Precinct extends Eloquent {

    /**
     * One-to-Many relationship
     * A district/precinct may have an arbitrary amount of voters.
     */
	public function voter() {
		return $this->hasMany('Voter');
	}
}