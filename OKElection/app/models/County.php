<?php
/**
 * Represents county information.
 *
 * @author   Jay Rivers <jrivers@printplace.com>
 */
class County extends Eloquent {

    /**
     * We don't need timestamps in our table for the county dataset.
     */
    public $timestamps = 'false';

    /**
     * Retrieve the id
     *
     * @return integer
     */
    public function getID() {
        return $this->id;
    }

    /**
     * Retrieve the name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }
}