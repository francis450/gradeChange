<?php

class Enrollment extends BaseModel
{
    protected $table = 'course_student';

    public function __construct()
    {
            parent::__construct();
    }

    public function course()
    {
        return $this->belongsTo('Course', 'course_id');
    }
}