<?php

class DashboardController extends BaseController
{
    public function __construct()
    {
        $this->checkAuthentication();
    }

    public function index()
    {
        $this->render('dashboard/index');
    }
}