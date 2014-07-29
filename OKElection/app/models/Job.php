<?php

/**
 * Class Job represents a mail job.
 */
class Job extends Eloquent {

    public function job() {
        return true;
    }

    public static function getNextID(){
        $Job = new Job;
        $Job->name = 'Test';
        $Job->save();
        return $Job->id;
    }
} 