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
    public $type;
    public $comparison;
    public $operator;

    public function __construct($name='field', $options=array(), $value='', $title='Field', $type='select', $operator=0, $comparison=0)
    {
        $this->name = $name;
        $this->options = $options;
        $this->value = $value;
        $this->title = $title;
        $this->type = $type;
        $this->operator = $operator;
        $this->comparison = $comparison;

        return $this;
    }


}