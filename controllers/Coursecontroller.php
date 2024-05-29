<?php

class CourseController extends BaseController
{
    public function __construct()
    {
        $this->checkAuthentication();
    }

    public function index()
    {
        $courses = new Course();
        $departments = new Department();

        $courses = $courses->all();

        foreach ($courses as $key => $course) {
            $department = $departments->find($course['department_id']);
            $courses[$key]['department'] = $department['name'];
        }

        $this->render('courses/index', compact('courses'));
    }

    public function department()
    {
        $course = new Course();
        $departmentModel = new Department();
        $student = new Student();
        $userModel = new User();

        $courses = $course->where('department_id', $_POST['department_id']);
        $students = $student->where('department_id', $_POST['department_id']);

        foreach ($courses as &$course) {
            $department = $departmentModel->find($course['department_id']);
            $course['department'] = $department['name'];
        }

        foreach ($students as &$student) {
            $user = $userModel->find($student['user_id']);
            if($user) {
                $firstname = $user['firstname'];
                $lastname = $user['lastname'];
                $student['name'] = $firstname.' '.$lastname;
            }
        }

        $response = [
            'courses' => $courses,
            'students' => $students
        ];

        echo json_encode($response);
    }

    public function students()
    {
        $student = new Student();
        $userModel = new User();
        $courseModel = new Course();
        
        $course = $courseModel->find($_POST['course_id']);
        $students = $student->where('department_id', $course['department_id']);

        foreach ($students as &$student) {
            $user = $userModel->find($student['user_id']);
            if($user) {
                $firstname = $user['firstname'];
                $lastname = $user['lastname'];
                $student['name'] = $firstname.' '.$lastname;
            }
        }

        echo json_encode($students);
    }

    public function create()
    {
        $departments = new Department();

        $departments = $departments->all();

        $this->render('courses/create', compact('departments'));
    }

    public function edit($params)
    {
        $course = new Course();
        $departments = new Department();

        $course = $course->find($params[0]);
        $departments = $departments->all(); 

        $this->render('courses/edit', compact('course', 'departments'));
    }

    public function update($params)
    {
        $course = new Course();
        $department = new Department();

        $departmentName = $department->find($_POST['department_id'])['name'];
        $abbrev = $this->getAbbreviation($departmentName);
        $courseAbrev = $this->getAbbreviation($_POST['name']);
        $courseCode = $abbrev . '-' . $courseAbrev;

        $data = [
            'name' => $_POST['name'],
            'department_id' => $_POST['department_id'],
            'code' => $courseCode,
        ];

        $course->update('id',$params[0], $data);

        header('Location: ' . base_url('courses'));
    }

    public function store()
    {
        $course = new Course();
        $department = new Department();

        $departmentName = $department->find($_POST['department_id'])['name'];
        $abbrev = $this->getAbbreviation($departmentName);
        $courseAbrev = $this->getAbbreviation($_POST['name']);
        $courseCode = $abbrev . '-' . $courseAbrev;

        $data = [
            'name' => $_POST['name'],
            'department_id' => $_POST['department_id'],
            'code' => $courseCode,
        ];

        $course->create($data);

        header('Location: ' . base_url('courses'));
    }

    public function delete($params)
    {
        $courseModel = new Course();

        $course = $courseModel->find($params);

        if($course && $courseModel->delete($params)){
            $this->redirect(base_url('courses'));
        }
    }

}