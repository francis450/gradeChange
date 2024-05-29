<?php

class Department extends BaseModel
{
    protected $table = 'departments';

    public function __construct()
    {
        parent::__construct();
    }

    public function courses()
    {
        return $this->hasMany('Course', 'department_id');
    }

    public function students()
    {
        return $this->hasMany('Student', 'department_id');
    }

    public function department_head()
    {
        return $this->belongsTo('FacultyMember', 'department_head');
    }
}