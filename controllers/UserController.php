<?php

class UserController extends BaseController
{
    public function __construct()
    {
        $this->checkAuthentication();
    }
    
    public function index()
    {
        $userModel = new User();

        $users = $userModel->all();

        $this->render('users/index', compact('users'));
    }

    public function create()
    {
        $this->render('users/create');
    }

    public function store()
    {
        $data = [
            'firstname' => $_POST['firstname'],
            'lastname' => $_POST['lastname'],
            'email' => $_POST['email'],
            'role' => $_POST['role'],
        ];
        $userModel = new User();
        $userModel = $userModel->create($data);
        if($userModel){
            $this->redirect(base_url('/users'));
        } else {
            return 'User creation failed';
        }
    }

    public function edit($params)
    {
        $user = new User;
        $user = $user->find($params[0]);

        $this->render('users/edit', compact('user'));
    }

    public function update($params)
    {
        $data = [
            'firstname' => $_POST['firstname'],
            'lastname' => $_POST['lastname'],
            'email' => $_POST['email'],
            'role' => $_POST['role'],
        ];

        $userModel = new User();

        $userModel->update('id',$params[0], $data);

        if($userModel) {
            $this->redirect(base_url('/users'));
        } else {
            return 'User update failed';
        }
    }

    public function delete($params)
    {
        $userModel = new User();
        if($userModel->delete($params[0])){
            $this->redirect(base_url('/users'));
        } else {
            return 'User deletion failed';
        }
    }
}