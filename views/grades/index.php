<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <h3>Grades</h3>
                <a href="<?php echo base_url('grades/create') ?>" class="btn btn-primary">Add Grade</a>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Points</th>
                        <th>Grade</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 ?>
                    <?php foreach ($grades as $grade) : ?>
                        <tr>
                            <td><?php echo $i++ ?></td>
                            <td><?php echo $grade['student_name']; ?></td>
                            <td><?php echo $grade['course_name']; ?></td>
                            <td><?php echo $grade['points']; ?></td>
                            <td><?php echo $grade['grade']; ?></td>
                            <td>
                                <a href="<?php echo base_url('grades/edit/' . $grade['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="<?php echo base_url('grades/delete/' . $grade['id']) ?>" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>