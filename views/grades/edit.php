<?php
// echo '<pre>';
// print_r($grade);
// echo '<pre>';
// print_r($students);
// echo '<pre>';
// print_r($departments);
// echo '<pre>';
// print_r($courses);
?>
<div class="container">
    <div class="row">
        <h3>Edit Grade</h3>
        <form action="<?php echo base_url('grades/update/' . $grade['id']) ?>" method="post" class="row">
            <div class="form-group col-6 col-md-4">
                <label for="student_id">Student</label>
                <select name="student_id" id="student_id" class="form-control">
                    <?php foreach ($students as $student) : ?>
                        <option value="<?php echo $student['id'] ?>" <?php echo $grade['student_id'] == $student['id'] ? 'selected' : '' ?>><?php echo $student['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-6 col-md-4">
                <label for="course_id">Course</label>
                <select name="course_id" id="course_id" class="form-control">
                    <?php foreach ($courses as $course) : ?>
                        <option value="<?php echo $course['id'] ?>" <?php echo $grade['course_id'] == $course['id'] ? 'selected' : '' ?>><?php echo $course['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-6 col-md-4">
                <label for="points">Points</label>
                <input type="text" name="points" id="points" class="form-control" value="<?php echo $grade['points'] ?>">
            </div>
            <div class="form-group col-6 col-md-4">
                <label for="grade">Grade</label>
                <input type="text" name="grade" id="grade" class="form-control" value="<?php echo $grade['grade'] ?>" readonly>
            </div>
            <div class="form-group col-6 col-md-4 d-flex align-items-end">

                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>