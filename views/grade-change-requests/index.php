
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center justify-content-between">
            <h3>Grade Change Requests</h3>
            <a href="<?php echo base_url('grade-change-requests/create') ?>" class="btn btn-outline-primary">New Request</a>
        </div>
        <table class="table" id="table" style="overflow-x:auto">
            <thead>
                <th>#</th>
                <?php if ($_SESSION['role'] != 'student') : ?>
                    <th>Student</th>
                <?php endif; ?>
                <th>Course</th>
                <th>Original Grade</th>
                <th>Request Grade</th>
                <th>Original Points</th>
                <th>Request Points</th>
                <th>Reason</th>
                <th>Status</th>
                <?php if ($_SESSION['role'] != 'student') : ?>
                    <th></th>
                <?php endif; ?>
            </thead>
            <tbody>
                <?php $id = 1; ?>
                <?php foreach ($gradeChangeRequests as $gradeChangeRequest) : ?>
                    <tr>
                        <td><?php echo $id++; ?></td>
                        <?php if ($_SESSION['role'] != 'student') : ?>
                            <td><?php echo $gradeChangeRequest['student_name'] ?></td>
                        <?php endif; ?>
                        <td><?php echo $gradeChangeRequest['course_name'] ?></td>
                        <td><?php echo $gradeChangeRequest['original_grade'] ?></td>
                        <td><?php echo $gradeChangeRequest['requested_grade'] ?></td>
                        <td><?php echo $gradeChangeRequest['original_points'] ?></td>
                        <td><?php echo $gradeChangeRequest['requested_points'] ?></td>
                        <td><?php echo $gradeChangeRequest['reason'] ?></td>
                        <td><?php echo $gradeChangeRequest['status'] ?></td>
                        <?php if ($_SESSION['role'] == 'student') : ?>
                            <td>
                                <a href="<?php echo base_url('/grade-change-requests/edit/' . $gradeChangeRequest['id']); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="<?php echo base_url('/grade-change-requests/delete/' . $gradeChangeRequest['id']); ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                            </td>
                        <?php elseif ($_SESSION['role'] == 'finance head' || $_SESSION['role'] == 'chairman' || $_SESSION['role'] == 'department head') : ?>
                            <td>
                                <a href="<?php echo base_url('/grade-change-requests/' . $gradeChangeRequest['id']); ?>" class="btn btn-sm btn-outline-success">Review</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>