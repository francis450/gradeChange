<?php

class FacultyMember extends BaseModel
{
    protected $table = 'faculty_members';

    public function __construct()
    {
        parent::__construct();
    }

    public function department()
    {
        return $this->belongsTo('Department', 'department_id');
    }
}