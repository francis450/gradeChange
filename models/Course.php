<?php

// this class is to handle all operations related to courses
class Course extends BaseModel
{
    protected $table = 'courses';

    public function __construct()
    {
        parent::__construct();
    }

    // get department that the course belongs to
    public function department()
    {
        return $this->belongsTo('Department', 'department_id');
    }
}