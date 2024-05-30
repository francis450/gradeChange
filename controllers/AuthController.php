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
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['user_name'] = $user['firstname'] . ' ' . $user['lastname'];
                $log = new Log();
                $log->createLog($user['id'], 'login', 'User logged in successfully');
                header('Location: ' . base_url('/dashboard'));
            } else {
                $_SESSION['error-message'] = 'Invalid email or password';
                $this->redirect(base_url('/login'));
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
                return;
            } else {
                // check if password and confirm password match
                if ($_POST['password'] !== $_POST['password_confirmation']) {
                    echo 'Passwords do not match';
                    return;
                }
                // save user to database
                $userModel->create([
                    'firstname' => $_POST['firstname'],
                    'lastname' => $_POST['lastname'],
                    'email' => $_POST['email'],
                    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                ]);

                header('Location: ' . base_url('/login'));
            }
        } else {
            $this->render('auth/register', [], false);
        }
    }

    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        header('Location: ' . base_url('/login'));
    }
}
