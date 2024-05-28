<?php

class Student extends BaseModel
{
    protected $table = 'students';

    public function __construct()
    {
        parent::__construct();
    }

    public function department()
    {
        return $this->belongsTo('Department', 'department_id');
    }

    public function courses()
    {
        return $this->belongsToMany('Course', 'course_student', 'student_id', 'course_id');
    }
}