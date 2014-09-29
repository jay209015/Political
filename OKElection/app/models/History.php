<?php

/**
 * Class History represents a voter's history i.e. all the elections that they've voted in.
 */
class History extends Eloquent {

    /**
     * Inverse of One-to-Many relationship
     * An arbitrary amount of voter history may belong to one voter.
     */
    public function voter() {
        return $this->belongsTo('Voter', 'voter_id_num', 'voter_id_num');
    }
} 