<div class="container">
    <h3>Add Grade Change Request</h3>
    <form action="<?php echo base_url('grade-change-requests/store') ?>" method="post" class="row">
        <?php if ($_SESSION['role'] != 'student') : ?>
            <div class="form-group col-6 col-md-4">
                <label for="department_id">Department</label>
                <select name="department_id" id="department_id" class="form-control">
                    <option value="">Select Department</option>
                    <?php foreach ($departments as $department) : ?>
                        <option value="<?php echo $department['id'] ?>"><?php echo $department['name']; ?></option>
                    <?php endforeach;  ?>
                </select>
            </div>
        <?php endif; ?>
        <?php if ($_SESSION['role'] != 'student') : ?>
            <div class="form-group col-6 col-md-4">
                <label for="student_id">Student</label>
                <select name="student_id" id="student_id" class="form-control ernrollment_student_id" required>
                    <option value="">Select Student</option>
                    <?php foreach ($students as $student) : ?>
                        <option value="<?php echo $student['id'] ?>"><?php echo $student['student_number'] . ' - ' . $student['name'] ?></option>
                    <?php endforeach;  ?>
                </select>
            </div>
        <?php endif; ?>
        <div class="form-group col-6 col-md-4">
            <label for="course_id">Course</label>
            <select name="course_id" id="course" class="form-control course_grade_id" required>
                <option value="">Select Course</option>
                <?php if ($_SESSION['role'] == 'student') : ?>
                <?php foreach ($courses as $course) : ?>
                    <option value="<?php echo $course['id'] ?>"><?php echo $course['name'] ?></option>
                <?php endforeach;  ?>
                <?php endif;  ?>
            </select>
        </div>
        <div class="form-group col-6 col-md-4">
            <label for="original_points">Points</label>
            <input type="number" name="original_points" class="form-control" id="original_points" readonly>
        </div>
        <div class="form-group col-6 col-md-4">
            <label for="original_grade">Grade</label>
            <input type="text" name="original_grade" class="form-control" id="original_grade" readonly>
        </div>
        <div class="form-group col-6 col-md-4">
            <label for="requested_points">Request Points</label>
            <input type="text" id="points" class="form-control" name="requested_points" required>
        </div>
        <div class="form-group col-6 col-md-4">
            <label for="requested_grade">Request Grade</label>
            <input type="text" id="grade" class="form-control" name="requested_grade" readonly>
        </div>
        <div class="form-group col-6 col-md-4">
            <label for="reason">Justification</label>
            <textarea name="reason" id="reason" class="form-control" required placeholder="State valid Reason for Grade Change"></textarea>
        </div>
        <?php if (isset($_SESSION['error-message'])) : ?>
            <div class="form-group col-6 col-md-4 alert alert-danger">
                <?php if (isset($_SESSION['error-message'])) {
                    echo $_SESSION['error-message'];
                    unset($_SESSION['error-message']);
                } ?>
            </div>
        <?php endif; ?>
        <div class="form-group col-6 col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>