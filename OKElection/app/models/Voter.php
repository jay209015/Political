<?php

/**
 * Represents an Oklahoman voter's registration information as well as how they voted.
 *
 * @author   Andre Patterson <apatterson@printplace.com>
 */
class Voter extends Eloquent {

	protected $fillable = [];
	
	/**
	 * Every voter must belong to a district/precinct.
	 */
	public function precinct() {
		return $this->belongsTo('Precinct');
	}
}