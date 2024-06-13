<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center justify-content-between">
            <h3>Enrollments</h3>
            <?php if ($_SESSION['role'] != 'student') : ?>
                <a href="<?php echo base_url('enrollments/create'); ?>" class="btn btn-outline-primary">Add Enrollment</a>
            <?php endif; ?>
        </div>
        <table class="table" style="overflow-x:auto">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student Number</th>
                    <?php if ($_SESSION['role'] != 'student') : ?>
                        <th>Student Name</th>
                    <?php endif; ?>
                    <th>Course Name</th>
                    <?php if ($_SESSION['role'] != 'student') : ?>
                        <th></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php $id = 1; ?>
                <?php foreach ($enrollments as $enrollment) : ?>
                    <tr>
                        <td><?php echo $id++; ?></td>
                        <td><?php echo $enrollment['student_number']; ?></td>
                        <?php if ($_SESSION['role'] != 'student') : ?>
                            <td><?php echo $enrollment['student_name']; ?></td>
                        <?php endif; ?>
                        <td><?php echo $enrollment['course_name']; ?></td>
                        <?php if ($_SESSION['role'] != 'student') : ?>
                            <td>
                                <a href="<?php echo base_url('/enrollments/edit/' . $enrollment['id']); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="<?php echo base_url('/enrollments/delete/' . $enrollment['id']); ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>