<div class="container">
    <h3>Edit Enrollment</h3>
    <form class="row" action="<?php echo base_url('faculty/update/' . $faculty['id']); ?>" method="post">
        <div class="form-group col-6 col-md-4">
            <label for="student_name">Student</label>
            <input disabled type="text" class="form-control" id="student_name" name="student_name" value="<?php echo $enrollment['student_name'];  ?>">
        </div>

        <div class="form-group col-6 col-md-4">
            <label for="student_number">Student Number</label>
            <input disabled type="text" class="form-control" id="student_number" name="student_number" value="<?php echo $enrollment['student_number'];  ?>">
        </div>

        <div class="form-group col-6 col-md-4">
            <label for="course_name">Course</label>
            <select name="course_name" id="course_name" class="form-control">
                <option value="">Select Course</option>
                <?php foreach ($courses as $course) : ?>
                <option value="<?php echo $course['id']; ?>" <?php echo $course['id'] == $enrollment['course_id'] ? 'selected' : ''; ?>><?php echo $course['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-6 col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-outline-primary ">SAVE</button>
        </div>
    </form>
</div>