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

        $departments = $departmentModel->all();

        $this->render('departments/index', compact('departments'));
    }

    public function create()
    {
        $faculty = new FacultyMember();
        $faculty = $faculty->all();
        $this->render('departments/create', compact('faculty'));
    }

    public function store()
    {
        $data = [
           "name" => $_POST['name'],
            "department_head" => $_POST['department_head']
        ];
        $departmentModel = new Department();
        $departmentModel = $departmentModel->create($data);
        if($departmentModel){
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
            'name' => $_POST['name'],
            'department_head' => $_POST['department_head']
        ];

        $departmentModel = new Department();

        $departmentModel->update('id',$params[0], $data);

        if($departmentModel) {
            $this->redirect(base_url('/departments'));
        } else {
            return 'Department update failed';
        }
    }

    public function delete($params)
    {
        $departmentModel = new Department();
        if($departmentModel->delete($params[0])){
            $this->redirect(base_url('/departments'));
        } else {
            return 'Department deletion failed';
        }
    }
}