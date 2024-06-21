<?php

use function PHPSTORM_META\type;

class GradeChangeRequestController extends BaseController
{
    public function __construct()
    {
        $this->checkAuthentication();
    }

    protected function changeGrade($id)
    {
        $gradeChangeRequestModel = new GradeChangeRequest();
        $gradeModel = new Grade();
        $gradeChangeActionModel = new GradeChangeAction();


        $gradeChangeRequest = $gradeChangeRequestModel->find($id);

        $approvals = $gradeChangeActionModel->whereAnd(['request_id' => $id, 'action' => 'approved']);
        if (count($approvals) == 3) {
            $data = [
                'status' => 'Approved'
            ];
            $gradeChangeRequestModel->update('id', $id, $data);

            $grade = $gradeModel->whereAnd(['student_id' => $gradeChangeRequest['student_id'], 'course_id' => $gradeChangeRequest['course_id']])[0];
            $grade_data = [
                'grade' => $gradeChangeRequest['requested_grade'],
                'points' => $gradeChangeRequest['requested_points']
            ];
            $gradeModel->update('id', $grade['id'], $grade_data);
        } else {
            $data = [
                'status' => 'ChairmanApproval'
            ];
            $gradeChangeRequestModel->update('id', $id, $data);
        }
    }

    public function approve($id)
    {
        $gradeChangeRequestModel = new GradeChangeRequest();
        $gradeChangeRequest = $gradeChangeRequestModel->find($id);

        if (!$gradeChangeRequest) {
            $_SESSION['error-message'] = 'Error Approving Grade Change Request. Please Try Again';
            return $this->index();
        }

        $action = $_POST['action'];
        if ($action == 'reject') {
            return $this->deny($id);
        } elseif ($action    == 'review') {
            return $this->handleReview($gradeChangeRequest);
        } elseif ($action == 'approved') {
            return $this->handleApproval($gradeChangeRequest);
        }
    }

    private function handleReview($gradeChangeRequest)
    {
        $gradeChangeActionModel = new GradeChangeAction();
        $gradeChangeRequestModel = new GradeChangeRequest();
        $data = [
            'request_id' => $gradeChangeRequest['id'],
            'action' => 'review',
            'feedback' => $_POST['feedback'],
            'created_by' => $_SESSION['user_id']
        ];
        $gradeChangeActionModel->create($data);

        $notificationModel = new Notification();
        $facultyModel = new FacultyMember();
        $userModel = new User();
        $courseModel = new Course();

        $department_head = $facultyModel->where('role', 'department head')[0];
        $department_head_user = $userModel->find($department_head['user_id']);
        $course = $courseModel->whereAnd(['id' => $gradeChangeRequest['course_id']])[0];

        $notification_data = [
            'type' => 'Update Grade Change Request',
            'user_id' => $department_head_user['id'],
            'message' => 'Grade Change Request has been reviewed by ' . $_SESSION['user_name'] . ' for ' . $course['name'] . '. Please review and take necessary action. Click the following to review the request, ' . '<a href="' . base_url('grade-change-requests/' . $gradeChangeRequest['id'] . '') . '">Grade Change Request</a>',
        ];

        $update_data = ['status' => 'Review'];
        if ($gradeChangeRequestModel->update('id', $gradeChangeRequest['id'], $update_data) && $notificationModel->create($notification_data)) {
            header('Location: ' . base_url('grade-change-requests/' . $gradeChangeRequest['id'] . ''));
            exit;
        } else {
            echo 'Error Reviewing Grade Change Request. Please Try Again';
        }
    }

    private function handleApproval($gradeChangeRequest)
    {
        $role = $_SESSION['role'];
        $data = [
            'request_id' => $gradeChangeRequest['id'],
            'action' => 'approved',
            'feedback' => $_POST['feedback'],
            'created_by' => $_SESSION['user_id']
        ];

        $gradeChangeActionModel = new GradeChangeAction();
        $gradeChangeActionModel->create($data);

        $courseModel = new Course();
        $studentModel = new Student();
        $userModel = new User();
        $notificationModel = new Notification();

        $course = $courseModel->whereAnd(['id' => $gradeChangeRequest['course_id']])[0];
        $student = $studentModel->find($gradeChangeRequest['student_id']);
        $user = $userModel->find($student['user_id']);

        $notification_data = [
            'user_id' => $user['id'],
            'type' => 'Grade Change Request Approved',
            'message' => 'Grade Change Request has been approved by ' . $_SESSION['user_name'] . ' for ' . $course['name'] . '. Click here to view the request, <a href="' . base_url('grade-change-requests/' . $gradeChangeRequest['id'] . '') . '">Grade Change Request</a>',
        ];

        if ($notificationModel->create($notification_data)) {
            $this->changeGrade($gradeChangeRequest['id']);
            header('Location: ' . base_url('grade-change-requests/' . $gradeChangeRequest['id']));
            exit;
        } else {
            echo 'Error Approving Grade Change Request';
        }
    }


    public function deny($id)
    {
        $gradeChangeRequestModel = new GradeChangeRequest();
        $gradeModel = new Grade();
        $studentModel = new Student();
        $courseModel = new Course();
        $userModel = new User();
        $notificationModel = new Notification();

        $gradeChangeRequest = $gradeChangeRequestModel->find($id);
        if ($gradeChangeRequest) {
            $data = [
                'status' => 'Denied'
            ];
            $course = $courseModel->whereAnd(['id' => $gradeChangeRequest['course_id']])[0];

            if ($gradeChangeRequestModel->update('id', $id, $data)) {
                $student = $studentModel->find($gradeChangeRequest['student_id']);
                $user = $userModel->find($student['user_id']);
                $notification_data = [
                    'user_id' => $user['id'],
                    'type' => 'Grade Change Request Denied',
                    'message' => 'Grade Change Request has been denied by ' . $_SESSION['user_name'] . ' for ' . $course['name'] . '. Feedback: ' . $_POST['feedback']
                ];

                if ($notificationModel->create($notification_data)) {
                    $_SESSION['success-message'] = 'Grade Change Request Denied Successfully';
                    header('Location: ' . base_url('grade-change-requests/' . $id));
                } else {
                    $_SESSION['error-message'] = 'Error Denying Grade Change Request. Please Try Again';
                    header('Location: ' . base_url('grade-change-requests/' . $id));
                }
            }
        }
    }

    public function show($id)
    {
        $gradeChangeRequestModel = new GradeChangeRequest();
        $gradeModel = new Grade();
        $studentModel = new Student();
        $courseModel = new Course();
        $userModel = new User();

        $gradeChangeRequest = $gradeChangeRequestModel->find($id);
        if ($gradeChangeRequest) {
            $student = $studentModel->where('id', $gradeChangeRequest['student_id'])[0];
            $user = $userModel->find($student['user_id']);
            $gradeChangeRequest['student_name'] = $user['firstname'] . ' ' . $user['lastname'];
            $course = $courseModel->where('id', $gradeChangeRequest['course_id'])[0];
            $gradeChangeRequest['course_name'] = $course['name'];

            $gradeChangeActionModel = new GradeChangeAction();

            $gradeChangeActions = $gradeChangeActionModel->where('request_id', $id);

            foreach ($gradeChangeActions as $key => $value) {
                $user = $userModel->find($value['created_by']);
                $gradeChangeActions[$key]['name'] = $user['firstname'] . ' ' . $user['lastname'];
                $gradeChangeActions[$key]['role'] = $user['role'];
            }

            $gradeChangeRequest['reviews'] = $gradeChangeActions;

            $this->render('grade-change-requests/show', compact('gradeChangeRequest'));
        }
    }

    public function index()
    {
        $gradeChangeRequestModel = new GradeChangeRequest();
        $gradeModel = new Grade();
        $studentModel = new Student();
        $courseModel = new Course();
        $userModel = new User();
        $gradeChangeActionModel = new GradeChangeAction();

        $gradeChangeRequests = [];
        if ($_SESSION['role'] == 'student') {
            $student = $studentModel->where('user_id', $_SESSION['user_id'])[0];
            $gradeChangeRequests = $gradeChangeRequestModel->where('student_id', $student['id']);
        } else if ($_SESSION['role'] == 'department head') {
            $departmentModel = new Department();
            $facultyModel = new FacultyMember();

            $faculty_department_id = $facultyModel->where('user_id', $_SESSION['user_id'])[0]['department_id'];
            $allgradeChangeRequests = $gradeChangeRequestModel->all();

            foreach ($allgradeChangeRequests as $gradeChangeRequest) {
                $student = $studentModel->find($gradeChangeRequest['student_id']);
                $student_department_id = $student['department_id'];
                if ($student_department_id == $faculty_department_id) {
                    $gradeChangeRequests[] = $gradeChangeRequest;
                }
            }
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
            $approvals = $gradeChangeActionModel->whereAnd(['request_id' => $gradeChangeRequest['id'], 'action' => 'approved']);
            $gradeChangeRequest['approvals'] = count($approvals);
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

        if ($_SESSION['role'] == 'student') {
            $student = $studentModel->where('user_id', $_SESSION['user_id'])[0];
            $student_id = $student['id'];
            $enrollments = $enrollmentModel->where('student_id', $student_id);
            $courses = [];
            foreach ($enrollments as $enrollment) {
                $course = $courseModel->find($enrollment['course_id']);
                $courses[] = $course;
            }
            $this->render('grade-change-requests/create', compact('courses'));
        } else {

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

            $this->render('grade-change-requests/create', compact('students', 'grades', 'departments'));
        }
    }

    public function store()
    {
        if ($_SESSION['role'] == 'student') {
            $studentModel = new Student();
            $student = $studentModel->where('user_id', $_SESSION['user_id'])[0];
            $student_id = $student['id'];
        } else {
            $student_id = $_POST['student_id'];
        }

        $gradeChangeRequestModel = new GradeChangeRequest();

        if ($gradeChangeRequestModel->exists(['student_id' => $student_id, 'course_id' => $_POST['course_id']])) {
            $_SESSION['error-message'] = 'Similar Request Already Exists.';
            $this->redirect(base_url('/grade-change-requests/create'));
        }
        // check if there is a file uploaded
        if (!empty($_FILES['attachment']['name'])) {
            $uploaddir = 'assets/uploads/';
            $uploadfile = $uploaddir . basename($_FILES['attachment']['name']);

            move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadfile);
        } else {
            $uploadfile = '';
        }

        $data = [
            'student_id' =>  $student_id,
            'course_id' => $_POST['course_id'],
            'original_grade' => $_POST['original_grade'],
            'requested_grade' => $_POST['requested_grade'],
            'original_points' => $_POST['original_points'],
            'requested_points' => $_POST['requested_points'],
            'reason' => $_POST['reason'],
            'created_by' => $_SESSION['user_id'],
            'attachments' => $uploadfile,
        ];

        $gradeChangeRequest = $gradeChangeRequestModel->create($data);

        if ($gradeChangeRequest) {


            $departmentModel = new Department();
            $studentModel = new Student();
            $facultyModel = new FacultyMember();
            $userModel = new User();
            $notificationModel = new Notification();
            $courseModel = new Course();

            $student = $studentModel->find($student_id);
            $department = $departmentModel->where('id', $student['department_id'])[0];
            $faculty = $facultyModel->whereAnd(['department_id' => $department['id'], 'role' => 'department head'])[0];
            $faculty_user = $userModel->find($faculty['user_id']);
            $course = $courseModel->find($data['course_id']);

            $notification_data = [
                'type' => 'New Grade Change Request Submitted',
                'user_id' => $faculty_user['id'],
                'message' => 'New Grade Change Request has been submitted by ' . $_SESSION['user_name'] . ' for ' . $course['name'] . '. Click here to review the request, <a href="' . base_url('grade-change-requests/' . $gradeChangeRequest) . '">Grade Change Request</a>',
            ];

            if ($notificationModel->create($notification_data)) {
                $_SESSION['success-message'] = 'Grade Change Request Saved Successfully';
                header('Location: ' . base_url('grade-change-requests'));
            } else {
                $_SESSION['error-message'] = 'Error Saving Grade Change Request. Please Try Again';
                $this->redirect(base_url('/grade-change-requests'));
            }
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
        // check if there is a file uploaded
        if (!empty($_FILES['attachment']['name'])) {
            $uploaddir = 'assets/uploads/';
            $uploadfile = $uploaddir . basename($_FILES['attachment']['name']);

            move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadfile);
        } else {
            $uploadfile = '';
        }

        $data = [
            'original_grade' => $_POST['original_grade'],
            'requested_grade' => $_POST['requested_grade'],
            'original_points' => $_POST['original_points'],
            'requested_points' => $_POST['requested_points'],
            'reason' => $_POST['reason'],
            'status' => 'Initiated',
            'attachments' => $uploadfile,
        ];


        if ($gradeChangeRequestModel->update('id', $id, $data)) {
            // notify the department head
            $departmentModel = new Department();
            $studentModel = new Student();
            $facultyModel = new FacultyMember();
            $userModel = new User();
            $notificationModel = new Notification();
            $courseModel = new Course();

            $gradeChangeRequest = $gradeChangeRequestModel->find($id);
            $student = $studentModel->find($gradeChangeRequest['student_id']);
            $department = $departmentModel->where('id', $student['department_id'])[0];
            $faculty = $facultyModel->whereAnd(['department_id' => $department['id'], 'role' => 'department head'])[0];
            $faculty_user = $userModel->find($faculty['user_id']);
            $course = $courseModel->find($gradeChangeRequest['course_id']);

            $notification_data = [
                'type' => 'Grade Change Request Updated',
                'user_id' => $faculty_user['id'],
                'message' => 'Grade Change Request has been updated by ' . $_SESSION['user_name'] . ' for ' . $course['name'] . '. Click here to review the request, <a href="' . base_url('grade-change-requests/' . $id . '') . '">Grade Change Request</a>',
            ];

            if ($notificationModel->create($notification_data)) {
                $_SESSION['success-message'] = 'Grade Change Request Updated Successfully';
                $this->redirect(base_url('grade-change-requests'));
            } else {
                $_SESSION['error-message'] = 'Error Updating Grade Change Request. Please Try Again';
                $this->redirect(base_url('/grade-change-requests/edit/' . $id));
            }
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
