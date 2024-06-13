<?php
// echo '<pre>';
// print_r($gradeChangeRequest);
// echo '<pre>';
?>
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between">
            <h4>Review Grade Change Request</h4>
        </div>
        <div class="row">
            <div class="form-group col-6 col-md-4">
                <label for="original_points">Student</label>
                <p class="border p-2 border-radius-2"><?php echo $gradeChangeRequest['student_name'] ?></p>
            </div>
            <div class="form-group col-6 col-md-4">
                <label for="original_points">Course</label>
                <p class="border p-2 border-radius-2"><?php echo $gradeChangeRequest['course_name'] ?></p>
            </div>
            <div class="form-group col-6 col-md-4">
                <label for="original_points">Original Points</label>
                <p class="border p-2 border-radius-2"><?php echo $gradeChangeRequest['original_points'] ?></p>
            </div>
            <div class="form-group col-6 col-md-4">
                <label for="original_grade">Original Grade</label>
                <p class="border p-2 border-radius-2"><?php echo $gradeChangeRequest['original_grade'] ?></p>
            </div>
            <div class="form-group col-6 col-md-4">
                <label for="requested_points">Requested Points</label>
                <p class="border p-2 border-radius-2"><?php echo $gradeChangeRequest['requested_points'] ?></p>
            </div>

            <div class="form-group col-6 col-md-4">
                <label for="requested_grade">Requested Grade</label>
                <p class="border p-2 border-radius-2"><?php echo $gradeChangeRequest['requested_grade'] ?></p>
            </div>
            <div class="form-group col-6 col-md-4">
                <label for="reason">Reason</label>
                <p class="border p-2 border-radius-2"><?php echo $gradeChangeRequest['reason'] ?></p>
            </div>
            <div class="form-group col-6 col-md-4">
            </div>
            <?php if (isset($_SESSION['error-message'])) : ?>
                <div class="form-group col-6 col-md-4 alert alert-danger">
                    <?php if (isset($_SESSION['error-message'])) {
                        echo $_SESSION['error-message'];
                        unset($_SESSION['error-message']);
                    } ?>
                </div>
            <?php endif; ?>
            <div class="col-12">
                <h5>Submit Review</h5>
                <hr class="col-12">
            </div>
            <div class="col-12">
                <div class="col-6 p-0">
                    <textarea name="feedback" id="feedback" class="form-control" placeholder="State reason for Approval/Denial"></textarea>
                </div>
            </div>
            <div class="form-group col-12 d-flex align-items-end mt-2">
                <a id='approve' class="btn btn-outline-primary mr-2">Approve</a>
                <a id='deny' class="btn btn-outline-danger">Deny</a>
            </div>
        </div>
    </div>
</div>