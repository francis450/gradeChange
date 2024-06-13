<?php

class EnrollmentController extends BaseController
{
    public function __construct()
    {
        $this->checkAuthentication();
    }

    public function index()
    {
        $enrollmentModel = new Enrollment();
        $studentModel = new Student();
        $courseModel = new Course();
        $userModel = new User();

        if ($_SESSION['role'] == 'student') {
            $student = $studentModel->where('user_id', $_SESSION['user_id'])[0];
            $enrollments = $enrollmentModel->where('student_id', $student['id']);
        }else if ($_SESSION['role'] == 'department head') {
            $facultyModel = new FacultyMember();
            $faculty = $facultyModel->where('user_id', $_SESSION['user_id'])[0];
            $students = $studentModel->where('department_id', $faculty['department_id']);
            $enrollments = [];
            
            foreach($students as $student) {
                $individualEnrollment = $enrollmentModel->where('student_id', $student['id']);
       
            foreach ($individualEnrollment as $enrollment){
                    $enrollments[] = $enrollment;
                }
            }
            
        } else {
            $enrollments = $enrollmentModel->all();
        }

        foreach ($enrollments as &$enrollment) {
            $student = $studentModel->find($enrollment['student_id']);
            $user = $userModel->find($student['user_id']);
            $firstname = $user['firstname'];
            $lastname = $user['lastname'];
            $enrollment['student_name'] = $firstname . ' ' . $lastname;
            $enrollment['student_number'] = $student['student_number'];
            $course = $courseModel->find($enrollment['course_id']);
            if ($course) {
                $enrollment['course_name'] = $course['name'];
            }
        }

        $this->render('enrollments/index', compact('enrollments'));
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

        $this->render('enrollments/create', compact('courses', 'students', 'departments'));
    }

    public function student()
    {
        if (!isset($_POST['student_id'])) {
            return;
        }

        $studentModel = new Student();
        $courseModel = new Course();
        $userModel = new User();
        $gradeModel = new Grade();

        $student = $studentModel->find($_POST['student_id']);

        // get all grades for the student
        $grades = $gradeModel->where('student_id', $student['id']);

        $courses = [];
        foreach ($grades as $grade) {
            $course = $courseModel->find($grade['course_id']);
            $courses[] = $course;
        }

        echo json_encode($courses);
    }

    public function store()
    {
        $enrollmentModel = new Enrollment();

        $data = [
            'student_id' => $_POST['student_id'],
            'course_id' => $_POST['course_id'],
        ];

        if ($enrollmentModel->exists(['student_id' => $_POST['student_id'], 'course_id' => $_POST['course_id']])) {
            $_SESSION['error-message'] = 'This enrollment already exists.';
            $this->redirect(base_url('/enrollments/create'));
        }

        if ($enrollmentModel->create($data)) {
            $this->redirect(base_url('/enrollments'));
        } else {
            echo 'Failed to enroll';
        }
    }

    public function edit($params)
    {
        $enrollmentModel = new Enrollment();
        $studentModel = new Student();
        $userModel = new User();
        $courseModel = new Course();
        $departmentModel = new Department();

        $enrollment = $enrollmentModel->find($params);
        $student = $studentModel->find($enrollment['student_id']);
        $user = $userModel->find($student['user_id']);
        $courses = $courseModel->where('department_id', $student['department_id']);

        $firstname = $user['firstname'];
        $lastname = $user['lastname'];
        $enrollment['student_name'] = $firstname . ' ' . $lastname;
        $enrollment['student_number'] = $student['student_number'];

        $this->render('enrollments/edit', compact('enrollment', 'courses'));
    }

    public function update($params)
    {
        $enrollmentModel = new Enrollment();

        $data = [
            'course_id' => $_POST['course_id'],
        ];

        if ($enrollmentModel->update($params, $data)) {
            $this->redirect(base_url('/enrollments'));
        } else {
            $this->redirect(base_url('/enrollments/edit/' . $params));
            $_SESSION['error-message'] = 'Failed to update';
        }
    }

    public function delete($params)
    {
        $enrollmentModel = new Enrollment();

        if ($enrollmentModel->delete($params)) {
            $_SESSION['success-message'] = 'Enrollment deleted successfully';
            $this->redirect(base_url('/enrollments'));
        } else {
            $_SESSION['error-message'] = 'Failed to delete enrollment';
        }
    }
}
