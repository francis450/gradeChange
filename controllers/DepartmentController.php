<?php

class DepartmentController extends BaseController
{

    public function __construct()
    {
        $this->checkAuthentication();
    }

    public function index()
    {
        $departmentModel = new Department();
        $facultyModel = new FacultyMember();
        $userModel = new User();

        $departments = $departmentModel->all();

        foreach ($departments as &$department) {
            $faculty = $facultyModel->where('department_id', $department['id']);
            if ($faculty) {
                foreach ($faculty as &$f) {
                    if ($f['role'] == 'department head') {
                        $user = $userModel->find($f['user_id']);
                        $firstname = $user['firstname'];
                        $lastname = $user['lastname'];
                        $department['department_head'] = $firstname . ' ' . $lastname;
                    } else {
                        $department['department_head'] = '';
                    }
                }
            }else{
                $department['department_head'] = '';
            }
        }

        $this->render('departments/index', compact('departments'));
    }

    public function create()
    {
        // $faculty = new FacultyMember();
        // $userModel = new User();

        // $faculty = $faculty->where('role', 'regular faculty');

        // foreach($faculty as &$f) {
        //     $firstname = ($userModel->find($f['user_id']))['firstname'];
        //     $lastname = $userModel->find($f['user_id'])['lastname'];
        //     $f['name'] = $firstname.' '.$lastname;
        // }

        $this->render('departments/create');
    }

    public function store()
    {
        $departmentModel = new Department();

        $data = [
            "name" => $_POST['name']
        ];

        $departmentModel = $departmentModel->create($data);
        if ($departmentModel) {
            $this->redirect(base_url('/departments'));
        } else {
            return 'Department creation failed';
        }
    }

    public function edit($params)
    {
        $departmentModel = new Department();
        $department = $departmentModel->find($params[0]);
        $faculty = new FacultyMember();
        $faculty = $faculty->all();
        $this->render('departments/edit', ['department' => $department, 'faculty' => $faculty]);
    }

    public function update($params)
    {
        $data = [
            'name' => $_POST['name']
        ];

        $departmentModel = new Department();

        $departmentModel->update('id', $params[0], $data);

        if ($departmentModel) {
            $this->redirect(base_url('/departments'));
        } else {
            return 'Department update failed';
        }
    }

    public function delete($params)
    {
        $departmentModel = new Department();
        if ($departmentModel->delete($params[0])) {
            $this->redirect(base_url('/departments'));
        } else {
            return 'Department deletion failed';
        }
    }
}
