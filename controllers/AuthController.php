<?php

class AuthController extends BaseController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_type'] = $user['type'];
                $_SESSION['user_name'] = $user['full_name'];
                echo 'success';
            } else {
                echo 'Invalid email or password';
            }
        } else {
            $data['error'] = 'Invalid email or password';
            $this->render('auth/login', $data, false);
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $user = $userModel->findByEmail($_POST['email']);

            if ($user) {
                echo 'Email already exists';
            } else {
                $userModel->create($_POST);
                echo 'success';
            }
        } else {
            $this->render('auth/register', [], false);
        }
    }

    public function logout()
    {
        unset($_SESSION['user']);
        header('Location: /login');
    }
}