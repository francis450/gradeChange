<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center justify-content-between">
            <h3>Students</h3>
            <a href="<?php echo base_url('students/create'); ?>" class="btn btn-outline-primary">Add Student</a>
        </div>
        <table class="table" style="overflow-x:auto">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Student Number</th>
                    <th>Department</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $id = 1; ?>
                <?php foreach ($students as $student) : ?>
                    <tr>
                        <td><?php echo $id++; ?></td>
                        <td><?php echo $student['name']; ?></td>
                        <td><?php echo $student['student_number']; ?></td>
                        <td><?php echo $student['department']; ?></td>
                        <td>
                            <a href="<?php echo base_url('/students/edit/' . $student['id']); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                            <a href="<?php echo base_url('/students/delete/' . $student['id']); ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>