<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center justify-content-between">
            <h3>Courses</h3>
            <?php if ($_SESSION['role'] != 'student') : ?>
                <a href="<?php echo base_url('courses/create'); ?>" class="btn btn-outline-primary">New Course</a>
            <?php endif; ?>
        </div>
        <table class="table mt-2" style="overflow-x:auto">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Department</th>
                    <?php if ($_SESSION['role'] != 'student') : ?>

                        <th></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php $id = 1; ?>
                <?php foreach ($courses as $course) : ?>
                    <tr>
                        <td><?php echo $id++; ?></td>
                        <td><?php echo $course['name']; ?></td>
                        <td><?php echo $course['code']; ?></td>
                        <td><?php echo $course['department']; ?></td>
                        <?php if ($_SESSION['role'] != 'student') : ?>
                            <td>
                                <a href="<?php echo base_url('/courses/edit/' . $course['id']); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="<?php echo base_url('/courses/delete/' . $course['id']); ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>