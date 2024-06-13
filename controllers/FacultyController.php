<?php

class FacultyController extends BaseController
{
    public function __construct()
    {
        $this->checkAuthentication();
    }

    public function index()
    {
        $facultyModel = new FacultyMember();
        $user = new User();
        $department = new Department();

        if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'finance head' || $_SESSION['role'] == 'chairman') {
            $faculty = $facultyModel->all();
        } else if ($_SESSION['role'] == 'department head') {
            $facultyn = $facultyModel->where('user_id', $_SESSION['user_id'])[0];
            $department_id = ($department->find($facultyn['department_id']))['id'];
            $faculty = $facultyModel->where('department_id', $department_id);
        }

        foreach ($faculty as &$f) {
            if ($f['department_id']) {
                $f['department_name'] = $department->find($f['department_id'])['name'];
            } else {
                $f['department_name'] = '';
            }
            $firstname = $user->find($f['user_id'])['firstname'];
            $lastname = $user->find($f['user_id'])['lastname'];
            $f['faculty_member_name'] = $firstname . ' ' . $lastname;
        }
        unset($f);


        $this->render('faculty/index', compact('faculty'));
    }

    public function create()
    {
        $userModel = new User();
        $departments = new Department();
        $faculty = new FacultyMember();

        $departments = $departments->all();
        $users = $userModel->where('role', 'user');
        $faculty = $faculty->all();

        // remove users whose user_id is already in faculty
        foreach ($faculty as $f) {
            foreach ($users as $key => $user) {
                if ($f['user_id'] == $user['id']) {
                    unset($users[$key]);
                }
            }
        }

        $this->render('faculty/create', compact('departments', 'users'));
    }

    public function store()
    {
        $facultyModel = new FacultyMember();
        $userModel = new User();

        $data = [
            'user_id' => $_POST['name'],
            'department_id' => $_POST['department'],
            'role' => $_POST['role']
        ];

        if ($_POST['role'] == 'department head') {
            $faculty = $facultyModel->where('department_id', $_POST['department']);
            if ($faculty) {
                $_SESSION['error-message'] = 'Department already has a head';
                $this->redirect(base_url('/faculty/create'));
            }
        }

        if ($_POST['role'] == 'finance head') {
            $faculty = $faculty->where('role', 'finance head');
            if ($faculty) {
                $_SESSION['error-message'] = 'Finance head already exists';
                $this->redirect(base_url('/faculty/create'));
            }
        }

        if ($_POST['role'] == 'chairman') {
            $faculty = $faculty->where('role', 'chairman');
            if ($faculty) {
                $_SESSION['error-message'] = 'Chairman already exists';
                $this->redirect(base_url('/faculty/create'));
            }
        }

        if ($facultyModel->create($data)) {
            $userModel->update('id', $_POST['name'], ['role' => $_POST['role']]);
            $this->redirect(base_url('/faculty'));
        } else {
            return 'faculty creation failed';
        }
    }

    public function edit($params)
    {
        $faculty = new FacultyMember;
        $department = new Department;

        $faculty = $faculty->find($params);
        $department = $department->all();

        $this->render('faculty/edit', compact('faculty', 'department'));
    }

    public function update($params)
    {
        if (!$_POST['role'] || !$_POST['department']) {
            $_SESSION['error-message'] = 'Please fill all fields';
            $this->redirect(base_url('/faculty/edit/' . $params));
        }

        $data = [
            'role' => $_POST['role'],
            'department_id' => $_POST['department']
        ];

        $facultyModel = new FacultyMember();

        $faculty = $facultyModel->update('id', $params, $data);

        if ($faculty) {
            $this->redirect(base_url('/faculty'));
        } else {
            $_SESSION['error-message'] = 'faculty update failed';
            $this->redirect(base_url('/faculty/edit/' . $params));
        }
    }

    public function delete($params)
    {
        $facultyModel = new FacultyMember();
        $userModel = new User();

        $faculty = $facultyModel->find($params);

        if ($faculty) {
            $user = $userModel->update('id', $faculty['user_id'], ['role' => 'user']);
            echo '<pre>';
            print_r($user);
            echo '<pre>';
            if ($facultyModel->delete($params)) {
                $this->redirect(base_url('/faculty'));
            } else {
                return 'faculty deletion failed';
            }
        }
    }
}
