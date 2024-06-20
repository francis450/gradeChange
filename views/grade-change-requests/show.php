<?php
// echo '<pre>';
// print_r($gradeChangeRequest);
// echo '<pre>';
?>
<div class="row h-100">

    <div class="row w-100 table table-responsive border-1 pl-3">
        <h5 class="ml-2">
            Grade Change Request
        </h5>
        <div class="row flex justify-content-around mr-0">
            <table class="col-6 table mr-1">

                <tr class="border">
                    <th class="border">Student</th>
                    <td><?php echo $gradeChangeRequest['student_name'] ?></td>
                </tr>
                <tr class="border">
                    <th class="border">Course</th>
                    <td><?php echo $gradeChangeRequest['course_name'] ?></td>
                </tr>
                <tr class="border">
                    <th class="border ">Justification</th>
                    <td><?php echo $gradeChangeRequest['reason'] ?></td>
                </tr>
                <tr class="border">
                    <th class="border">File Attachments</th>
                    <td>
                        <?php if ($gradeChangeRequest['attachments']) : ?>
                            <a href="<?php echo base_url( $gradeChangeRequest['attachments']); ?>" download>Download</a>
                        <?php else : ?>
                            No attachments
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            <table class="col-4 table">
                <thead>
                    <tr class="border">
                        <th></th>
                        <th>Original</th>
                        <th>Requested</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border">
                        <th>Points</th>
                        <td><?php echo $gradeChangeRequest['original_points'] ?></td>
                        <td><?php echo $gradeChangeRequest['requested_points'] ?></td>
                    </tr>
                    <tr class="border">
                        <th>Grade</th>
                        <td><?php echo $gradeChangeRequest['original_grade'] ?></td>
                        <td><?php echo $gradeChangeRequest['requested_grade'] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <h5>Review History</h5>
                <?php if ($_SESSION['role'] != 'student') : ?>
                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">
                        NEW
                    </button>
                <?php endif; ?>
            </div>
            <hr class="col-12 m-0 mb-1 p-0">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Reviewer</th>
                        <th>Role</th>
                        <th>Feedback</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $id = 1;
                    if ($gradeChangeRequest['reviews']) : ?>
                        <?php foreach ($gradeChangeRequest['reviews'] as $review) : ?>
                            <tr>
                                <td><?php echo $id++ ?></td>
                                <td><?php echo $review['name'] ?></td>
                                <td><?php echo $review['role'] ?></td>
                                <td><?php echo $review['feedback'] ?></td>
                                <td><?php echo $review['action'] ?></td>
                                <td><?php echo $review['created_at'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="4">No reviews</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Submit New Review</h5>
                <button type="button" class="btn-close " data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-2">
                    <label for="action">Action</label>
                    <select class="form-control" id="action" name="action">
                        <option value="">Select Action</option>
                        <option value="approved">Approve Request</option>
                        <option value="denied">Reject Request</option>
                        <option value="review">Request for Review</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="feedback">Comment</label>
                    <textarea class="form-control" id="feedback" name="feedback" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="approve">Submit</button>
            </div>
        </div>
    </div>
</div>