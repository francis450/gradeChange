
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center justify-content-between">
            <h3>Enrollments</h3>
            <a href="<?php echo base_url('enrollments/create'); ?>" class="btn btn-outline-primary">Add Enrollment</a>
        </div>
        <table class="table" style="overflow-x:auto">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student Number</th>
                    <th>Student Name</th>
                    <th>Course Name</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $id = 1; ?>
                <?php foreach($enrollments as $enrollment): ?>
                    <tr>
                        <td><?php echo $id++; ?></td>
                        <td><?php echo $enrollment['student_number']; ?></td>
                        <td><?php echo $enrollment['student_name']; ?></td>
                        <td><?php echo $enrollment['course_name']; ?></td>
                        <td>
                            <a href="<?php echo base_url('/enrollments/edit/' . $enrollment['id']); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                            <a href="<?php echo base_url('/enrollments/delete/' . $enrollment['id']); ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>