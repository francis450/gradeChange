<?php

class GradeController extends BaseController
{
    public function __construct()
    {
        $this->checkAuthentication();
    }

    public function index()
    {
        $gradeModel = new Grade();
        $studentModel = new Student();
        $courseModel = new Course();
        $userModel = new User();

        if ($_SESSION['role'] == 'student') {
            $student = $studentModel->where('user_id', $_SESSION['user_id'])[0];
            $grades = $gradeModel->where('student_id', $student['id']);
        }else if ($_SESSION['role'] == 'department head') {
            $departmentModel = new Department();
            $facultyModel = new FacultyMember();

            $faculty = $facultyModel->where('user_id', $_SESSION['user_id'])[0];
            $students = $studentModel->where('department_id', $faculty['department_id']);
            $grades = [];
            foreach ($students as $student) {
                $grades = $gradeModel->where('student_id', $student['id']);
            }
        } else {
            $grades = $gradeModel->all();
        }
        foreach ($grades as &$grade) {
            $student = $studentModel->find($grade['student_id']);
            $user = $userModel->find($student['user_id']);
            $firstname = $user['firstname'];
            $lastname = $user['lastname'];
            $grade['student_name'] = $firstname . ' ' . $lastname;
            $grade['student_number'] = $student['student_number'];
            $course = $courseModel->find($grade['course_id']);
            if ($course) {
                $grade['course_name'] = $course['name'];
            }
        }

        $this->render('grades/index', compact('grades'));
    }

    public function course()
    {
        if (!isset($_POST['course_id'])) {
            return;
        }

        if ($_SESSION['role'] == 'student') {
            $studentModel = new Student();
            $student = $studentModel->where('user_id', $_SESSION['user_id'])[0];
            $student_id = $student['id'];
        } else {
            $student_id = $_POST['student_id'];
        }
        
        $gradeModel = new Grade();

        $conditions = [
            'course_id' => $_POST['course_id'],
            'student_id' => $student_id 
        ];

        $grade = $gradeModel->whereAnd($conditions);

        return json_encode($grade);
    }

    public function create()
    {
        $courseModel = new Course();
        $studentModel = new Student();
        $userModel = new User();
        $departmentModel = new Department();

        $departments = $departmentModel->all();
        $students = $studentModel->all();
        $courses = $courseModel->all();

        foreach ($students as &$student) {
            $user = $userModel->find($student['user_id']);
            if ($user) {
                $firstname = $user['firstname'];
                $lastname = $user['lastname'];
                $student['name'] = $firstname . ' ' . $lastname;
            }
        }

        $this->render('grades/create', compact('courses', 'students', 'departments'));
    }

    public function store()
    {
        $gradeModel = new Grade();

        $data = [
            'course_id' => $_POST['course_id'],
            'student_id' => $_POST['student_id'],
            'points' => $_POST['points'],
            'grade' => $_POST['grade'],
            'faculty_id' => $_SESSION['user_id']
        ];
        if ($gradeModel->exists(['student_id' => $_POST['student_id'], 'course_id' => $_POST['course_id']])) {
            $_SESSION['error-message'] = 'This Grade Entry Already Exists.';
            $this->redirect(base_url('/grades/create'));
        }

        if ($gradeModel->create($data)) {
            $this->redirect(base_url('grades'));
        } else {
            $_SESSION['error_message'] = 'Grade creation failed';
            $this->redirect(base_url('grades/create'));
        }
    }

    public function edit($params)
    {
        $gradeModel = new Grade();
        $courseModel = new Course();
        $studentModel = new Student();
        $userModel = new User();
        $departmentModel = new Department();

        $departments = $departmentModel->all();
        $students = $studentModel->all();
        $courses = $courseModel->all();
        $grade = $gradeModel->find($params);

        foreach ($students as &$student) {
            $user = $userModel->find($student['user_id']);
            if ($user) {
                $firstname = $user['firstname'];
                $lastname = $user['lastname'];
                $student['name'] = $firstname . ' ' . $lastname;
            }
        }

        $this->render('grades/edit', compact('grade', 'courses', 'students', 'departments'));
    }

    public function update($params)
    {
        $gradeModel = new Grade();

        $data = [
            'course_id' => $_POST['course_id'],
            'student_id' => $_POST['student_id'],
            'points' => $_POST['points'],
            'grade' => $_POST['grade'],
            'faculty_id' => $_SESSION['user_id']
        ];

        if ($gradeModel->update('id', $params, $data)) {
            $this->redirect(base_url('grades'));
        } else {
            $_SESSION['error_message'] = 'Grade update failed';
            $this->redirect(base_url('grades/edit/' . $params));
        }
    }

    public function delete($params)
    {
        $gradeModel = new Grade();
        if ($gradeModel->delete($params)) {
            $this->redirect(base_url('grades'));
        } else {
            $_SESSION['error_message'] = 'Grade deletion failed';
        }
    }
}
