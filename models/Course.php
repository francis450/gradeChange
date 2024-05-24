<?php

// this class is to handle all operations related to courses
class Course extends BaseModel
{
    protected $table = 'courses';

    public function __construct()
    {
        parent::__construct();
    }
}