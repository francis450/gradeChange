<div class="container">
    <h3>Enroll Student to Course</h3>
    <form class="row" action="<?php echo base_url('enrollments/store'); ?>" method="post">
        <?php if ($_SESSION['role'] == 'admin') : ?>
            <div class="form-group col-6 col-md-4">
                <label for="department_id">Department</label>
                <select name="department_id" id="department_id" class="form-control">
                    <option value="">Select Department</option>
                    <?php foreach ($departments as $department) : ?>
                        <option value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

        <div class="form-group col-6 col-md-4">
            <label for="course_id">Course</label>
            <select name="course_id" id="course_id" class="form-control">
                <option value="">Select Course</option>

            </select>
        </div>

        <div class="form-group col-6 col-md-4">
            <label for="student_id">Student</label>
            <select name="student_id" id="student_id" class="form-control">
                <option value="">Select Student</option>
                <?php foreach ($students as $student) : ?>
                    <option value="<?php echo $student['id']; ?>"><?php echo $student['student_number'] . ' - ' . $student['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-6 col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-outline-primary ">SAVE</button>
        </div>
        <?php if(isset($_SESSION['error-message'])) : ?>
        <div class="alert alert-danger">
            <p class="error">
                <?php echo $_SESSION['error-message'] ?? ''; unset($_SESSION['error-message']); ?>
            </p>
        </div>
        <?php endif; ?>
    </form>
</div>