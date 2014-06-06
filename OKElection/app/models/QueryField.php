<?php

/**
 * Simple field object for the query page.
 *
 * @author    Jay Rivers <jrivers@printplace.com>
 */
class QueryField {

    public $name;
    public $options;
    public $value;
    public $title;

    public function __construct($name='field', $options=array(), $value='', $title='Field')
    {
        $this->name = $name;
        $this->options = $options;
        $this->value = $value;
        $this->title = $title;

        return $this;
    }


}