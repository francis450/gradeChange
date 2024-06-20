<?php
$columns = [
    ['data' => '#'],
    ['data' => 'course_name'],
    ['data' => 'original_grade'],
    ['data' => 'requested_grade'],
    ['data' => 'status']
];
if ($_SESSION['role'] != 'student') {
    array_splice($columns, 1, 0, [['data' => 'student_name']]);
    $columns[] = ['data' => 'actions'];
} else {
    $columns[] = ['data' => 'actions'];
}

?>
<div class="row h-100">
    <div class="col-md-12">
        <div class="d-flex align-items-center justify-content-between mb-1">
            <h4>Grade Change Requests</h4>
            <div class="btn-group">
                <!-- <button class="btn btn-xs btn-secondary border-round mr-2" id="open-request" disabled>Open Request</button> -->
                <a href="<?php echo base_url('grade-change-requests/create') ?>" class="btn btn-outline-primary">New Request</a>
            </div>
        </div>
        <hr class="m-0">
        <div class="d-flex align-items-center justify-content-between mb-1">
            <div class="d-flex align-items-center flex-grow-1">
                <div class="form-group mt-1 mb-1">
                    <select name="filter" id="filter" class="form-control">
                        <option value="">All</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

                <!-- bulk actions -->
                <div class="form-group mt-1 mb-1 mr-2 ml-2">
                    <select name="bulk-action" id="bulk-action" class="form-control ">
                        <option value="">Actions</option>
                        <option value="approve">Approve</option>
                        <option value="reject">Reject</option>
                    </select>
                </div>
            </div>

        </div>
        <hr class="m-0">
        <table class="display responsive nowrap table" id="grade-change-requests" style="overflow-x:auto">
            <thead>
                <tr>
                    <th>#</th>
                    <?php if ($_SESSION['role'] != 'student') : ?>
                        <th>Student</th>
                    <?php endif; ?>
                    <th>Course</th>
                    <th>Original Grade</th>
                    <th>Request Grade</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $id = 1; ?>
                <?php foreach ($gradeChangeRequests as $gradeChangeRequest) : ?>
                    <a href="<?php echo base_url('grade-change-requests/' . $gradeChangeRequest['id']); ?> ">
                    <tr id="<?php echo $gradeChangeRequest['id']; ?>">
                        <td><?php echo $id++; ?></td>
                        <?php if ($_SESSION['role'] != 'student') : ?>
                            <td><?php echo $gradeChangeRequest['student_name'] ?></td>
                        <?php endif; ?>
                        <td><?php echo $gradeChangeRequest['course_name'] ?></td>
                        <td><?php echo $gradeChangeRequest['original_grade'] ?></td>
                        <td><?php echo $gradeChangeRequest['requested_grade'] ?></td>
                        <td><?php
                            echo $gradeChangeRequest['approvals']. '/3' ;
                            ?></td>
                        <td>
                            <?php if ($_SESSION['role'] == 'student') : ?>
                                <a href="<?php echo base_url('/grade-change-requests/edit/' . $gradeChangeRequest['id']); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="<?php echo base_url('/grade-change-requests/delete/' . $gradeChangeRequest['id']); ?>" class="btn btn-sm btn-outline-danger">Delete</a>

                            <?php endif; ?>
                        </td>
                    </tr>
                    </a>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        var columns = <?php echo json_encode($columns); ?>;
        var table = new DataTable('#grade-change-requests', {
            searchable: true,
            sortable: true,
            columns: columns,
            select: true,
            lengthChange: false,
            layout: {

            }
        });

        table.on('dblclick', 'tbody tr', function(e) {
            var id = e.currentTarget.id;

            window.location.href = '<?php echo base_url('grade-change-requests/') ?>' + id;
        });

        table.on('click', 'tbody tr', function(e) {
            e.currentTarget.classList.toggle('selected');

            if (table.rows('.selected').count() === 1 && $('#open-request').prop('disabled') == true) {
                $('#open-request').prop('disabled', false);
            } else if (table.rows('.selected').count() > 1 && $('#open-request').prop('disabled') == false) {
                $('#open-request').prop('disabled', true);
            }
        });

        $('#filter').on('change', function() {
            var filterValue = $(this).val();
            if (filterValue) {
                table.search(filterValue).draw();
            } else {
                table.search('').draw();
            }
        });
    });
</script>