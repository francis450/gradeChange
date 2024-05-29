<div class="container">
    <h3>Edit Student Details</h3>
    <form class="row" action="<?php echo base_url('students/update/'.$student['id']); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
        <div class="form-group col-6 col-sm-4 col-6 col-sm-4">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo $student['name']; ?>" readonly>
        </div>
        <div class="form-group col-6 col-sm-4">
            <label for="student_number">Student Number</label>
            <input type="text" name="student_number" class="form-control" value="<?php echo $student['student_number']; ?>" readonly>
        </div>
        <div class="form-group col-6 col-sm-4">
            <label for="department_id">Department</label>
            <select name="department_id" class="form-control">
                <?php foreach ($departments as $department) : ?>
                    <option value="<?php echo $department['id']; ?>" <?php echo $department['id'] == $student['department_id'] ? 'selected' : ''; ?>><?php echo $department['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-6 col-sm-4 d-flex align-items-end">
            <button type="submit" class="btn btn-outline-primary ">SAVE</button>
        </div>
</div>