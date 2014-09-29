<?php
/**
 * Represents county information.
 *
 * @author   Jay Rivers <jrivers@printplace.com>
 */
class Candidate extends Eloquent {

    /**
     * We don't need timestamps in our table for the county dataset.
     */
    public $timestamps = 'false';

}