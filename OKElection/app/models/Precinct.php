<?php

/**
 * Represents precinct/district information.
 *
 * @author   Andre Patterson <apatterson@printplace.com>
 */
class Precinct extends Eloquent {
	protected $fillable = [];
	
	/**
	 * Any precinct/district can have an arbitrary amount of voters.
	 */
	public function precinct() {
		return $this->hasMany('Voter');
	}
}