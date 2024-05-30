<div class="container">
    <h3>Asssign Grade</h3>
    <form action="<?php echo base_url('grades/store')?>" method="POST" class="row">
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
            <select name="course_id" id="course_id" class="form-control" required>
                <option value="">Select Course</option>
                <?php if ($_SESSION['role'] !== 'admin') : ?>
                    <?php foreach ($courses as $course) : ?>
                        <option value="<?php echo $course['id']; ?>"><?php echo $course['name']; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="form-group col-6 col-md-4">
            <label for="student_id">Student</label>
            <select name="student_id" id="student_id" class="form-control" required>
                <option value="">Select Student</option>
                <?php if ($_SESSION['role'] !== 'admin') : ?>
                    <?php foreach ($students as $student) : ?>
                        <option value="<?php echo $student['id']; ?>"><?php echo $student['name']; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="form-group col-6 col-md-4">
            <label for="points">Points</label>
            <input type="number" name="points" id="points" class="form-control" required>
        </div>
        
        <div class="form-group col-6 col-md-4">
            <label for="grade">Grade</label>
            <input type="text" name="grade" id="grade" class="form-control" readonly>
        </div>
        
        <div class="form-group col-6 col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <?php if(isset($_SESSION['error-message'])) : ?>
        <div class="form-group col-6 col-md-4 d-flex align-items-end">
            <div class="alert alert-danger"><?php echo $_SESSION['error-message']; unset($_SESSION['error-message']); ?></div>
        </div>
        <?php endif; ?>
    </form>
</div>