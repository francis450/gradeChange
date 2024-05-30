<?php

class GradeChangeRequestController extends BaseController
{
    public function __construct()
    {
        $this->checkAuthentication();
    }

    public function index()
    {
        $gradeChangeRequestModel = new GradeChangeRequest();
        $gradeModel = new Grade();
        $studentModel = new Student();
        $courseModel = new Course();
        $userModel = new User();


        if ($_SESSION['role'] == 'student') {
            $student = $studentModel->where('user_id', $_SESSION['user_id']);
            $gradeChangeRequests = $gradeChangeRequestModel->where('student_id', $student['id']);
        } else {
            $gradeChangeRequests = $gradeChangeRequestModel->all();
        }

        foreach ($gradeChangeRequests as &$gradeChangeRequest) {
            // get course name for the request
            $course = $courseModel->find($gradeChangeRequest['course_id']);

            $gradeChangeRequest['course_name'] = $course['name'];

            $student = $studentModel->find($gradeChangeRequest['student_id']);
            $user = $userModel->find($student['user_id']);

            $firstname = $user['firstname'];
            $lastname = $user['lastname'];

            $gradeChangeRequest['student_name'] = $firstname . ' ' . $lastname;
        }

        $this->render('grade-change-requests/index', compact('gradeChangeRequests'));
    }

    public function create()
    {
        $gradeModel = new Grade();
        $studentModel = new Student();
        $userModel = new User();
        $courseModel = new Course();
        $departmentModel = new Department();
        $enrollmentModel = new Enrollment();

        $students = $studentModel->all();
        $grades = $gradeModel->all();
        $departments = $departmentModel->all();

        foreach ($students as &$student) {
            $user = $userModel->find($student['user_id']);
            if ($user) {
                $firstname = $user['firstname'];
                $lastname = $user['lastname'];
                $student['name'] = $firstname . ' ' . $lastname;
            }
        }

        $this->render('grade-change-requests/create', compact('students', 'departments'));
    }

    public function store()
    {
        if ($_SESSION['role'] == 'student') {
            $studentModel = new Student();
            $student = $studentModel->where('user_id', $_SESSION['user_id']);
            $student_id = $student['id'];
        } else {
            $student_id = $_POST['student_id'];
        }

        $gradeChangeRequestModel = new GradeChangeRequest();

        if ($gradeChangeRequestModel->exists(['student_id' => $student_id, 'course_id' => $_POST['course_id']])) {
            $_SESSION['error-message'] = 'Similar Request Already Exists.';
            $this->redirect(base_url('/grade-change-requests/create'));
        }

        $data = [
            'student_id' =>  $student_id,
            'course_id' => $_POST['course_id'],
            'original_grade' => $_POST['original_grade'],
            'requested_grade' => $_POST['requested_grade'],
            'original_points' => $_POST['original_points'],
            'requested_points' => $_POST['requested_points'],
            'reason' => $_POST['reason'],
            'created_by' => $_SESSION['user_id']
        ];


        if ($gradeChangeRequestModel->create($data)) {
            header('Location: ' . base_url('grade-change-requests'));
        } else {
            $_SESSION['error-message'] = 'Error Saving Grade Change Request. Please Try Again';
            $this->redirect(base_url('/grade-change-requests/create'));
        }
    }

    public function edit($id)
    {
        $gradeChangeRequestModel = new GradeChangeRequest();
        $gradeModel = new Grade();
        $studentModel = new Student();
        $courseModel = new Course();
        $userModel = new User();

        $gradeChangeRequest = $gradeChangeRequestModel->find($id);

        $this->render('grade-change-requests/edit', compact('gradeChangeRequest'));
    }

    public function update($id)
    {
        $gradeChangeRequestModel = new GradeChangeRequest();

        $data = [
            'original_grade' => $_POST['original_grade'],
            'requested_grade' => $_POST['requested_grade'],
            'original_points' => $_POST['original_points'],
            'requested_points' => $_POST['requested_points'],
            'reason' => $_POST['reason'],
            'status' => $_POST['status']
        ];

        if ($gradeChangeRequestModel->update('id', $id, $data)) {
            $this->redirect(base_url('grade-change-requests'));
        } else {
            $_SESSION['error-message'] = 'Error Updating Grade Change Request. Please Try Again';
            $this->redirect(base_url('/grade-change-requests/edit/' . $id));
        }
    }

    public function delete($id)
    {
        $gradeChangeRequestModel = new GradeChangeRequest();

        $gradeChangeRequestModel->delete($id);

        header('Location: ' . base_url('grade-change-requests'));
    }
}
