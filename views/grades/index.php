<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <h3>Grades</h3>
                <?php if ($_SESSION['role'] != 'student') : ?>
                    <a href="<?php echo base_url('grades/create') ?>" class="btn btn-primary">Add Grade</a>
                <?php endif; ?>
            </div>
            <table id="grades" class="display responsive nowrap table" style="overflow-x:auto">
                <thead>
                    <tr>
                        <th>#</th>
                        <?php if ($_SESSION['role'] != 'student') : ?>
                            <th>Student</th>
                        <?php endif; ?>
                        <th>Course</th>
                        <th>Points</th>
                        <th>Grade</th>
                        <?php if ($_SESSION['role'] != 'student') : ?>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 ?>
                    <?php foreach ($grades as $grade) : ?>
                        <tr>
                            <td><?php echo $i++ ?></td>
                            <?php if ($_SESSION['role'] != 'student') : ?>
                                <td><?php echo $grade['student_name']; ?></td>
                            <?php endif; ?>
                            <td><?php echo $grade['course_name']; ?></td>
                            <td><?php echo $grade['points']; ?></td>
                            <td><?php echo $grade['grade']; ?></td>
                            <?php if ($_SESSION['role'] != 'student') : ?>
                                <td>
                                    <a href="<?php echo base_url('grades/edit/' . $grade['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="<?php echo base_url('grades/delete/' . $grade['id']) ?>" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var table = new DataTable('#grades', {
            searchable: true,
            sortable: true,
            select: true,
        });

        table.on('click', 'tbody tr', function(e) {
            e.currentTarget.classList.toggle('selected');
            console.log('Target: ',e.currentTarget);
        });
    });
</script>