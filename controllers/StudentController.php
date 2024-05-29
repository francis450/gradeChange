<?php

class StudentController extends BaseController
{
    public function __construct()
    {
        $this->checkAuthentication();
    }

    public function index()
    {
        $students = new Student();

        $students = $students->all();

        foreach ($students as &$student) {
            $student['department'] = (new Department())->find($student['department_id'])['name'];
            $firstname = ((new User())->find($student['user_id']))['firstname'];
            $lastname = ((new User())->find($student['user_id']))['lastname'];
            $student['name'] = $firstname . ' ' . $lastname;
        }

        $this->render('students/index', compact('students'));
    }

    public function create()
    {
        $departments = new Department();
        $user = new User();

        $student = $user->where('role', 'student');
        $user = $user->where('role', 'user');

        $users = [];
        foreach ($user as $u) {
            $users[] = $u;
        }

        foreach ($student as $s) {
            $users[] = $s;
        }

        foreach ($users as $key => $user) {
            if ((new Student())->where('user_id', $user['id'])) {
                unset($users[$key]);
            }
        }

        $departments = $departments->all();

        $this->render('students/create', compact('departments', 'users'));
    }

    public function store()
    {
        $student = new Student();
        $departments = new Department();

        $department = $departments->find($_POST['department_id']);
        $department_name = $department['name'];
        $department_abbreviation = $this->getAbbreviation($department_name);

        $data = [
            'user_id' => $_POST['user_id'],
            'student_number' => $department_abbreviation . '-' . $_POST['user_id'], // 'CSE-1234
            'department_id' => $_POST['department_id'],
        ];

        if ($student->create($data)) {
            $this->redirect(base_url('/students'));
        } else {
            echo "Error while saving data. Please try again.";
        }
    }

    public function edit($params)
    {
        $student = new Student();
        $departments = new Department();
        $user = new User();

        $student = $student->find($params[0]);
        $department = $departments->find($student['department_id']);
        $user = $user->find($student['user_id']);

        $student['department'] = $department['name'];
        $student['name'] = $user['firstname'] . ' ' . $user['lastname'];

        $departments = $departments->all();

        $this->render('students/edit', compact('student', 'departments'));
    }

    public function update($params)
    {
        $studentModel = new Student();
        $departments = new Department();

        $department = $departments->find($_POST['department_id']);
        $department_name = $department['name'];
        $department_abbreviation = $this->getAbbreviation($department_name);
        $student = $studentModel->find($params[0]);
        $data = [
            'user_id' => $student['user_id'],
            'student_number' => $department_abbreviation . '-' . $params[0], // 'CSE-1234
            'department_id' => $_POST['department_id'],
        ];

        if ($studentModel->update('id', $params[0], $data)) {
            $this->redirect(base_url('/students'));
        } else {
            echo "Error while updating data. Please try again.";
        }
    }

    public function delete($params)
    {
        $studentModel = new Student();
        $userModel = new User();

        $student = $studentModel->find($params);
        $user = $userModel->find($student['user_id']);
        // echo '<pre>';
        // print_r($user);
        // echo '<pre>';
        if ($userModel->update('id', $student['user_id'], ['role' => 'user'])) {
            $studentModel->delete($params);
            $this->redirect(base_url('/students'));
        } else {
            echo "Error while deleting data. Please try again.";
        }
    }

    function getAbbreviation($text)
    {
        // Split the text into words
        $words = explode(' ', $text);
        $abbreviation = '';

        // Iterate through each word
        foreach ($words as $word) {
            // Check if the word is not an empty string
            if (!empty($word)) {
                // Add the first letter of the word to the abbreviation
                $abbreviation .= $word[0];
            }
        }

        // Convert the abbreviation to uppercase
        return strtoupper($abbreviation);
    }
}
