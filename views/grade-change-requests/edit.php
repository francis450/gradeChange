<div class="container">
    <div class="row">
        <h3>Edit Grade Change Request</h3>
        <form enctype="multipart/form-data" action="<?php echo base_url('/grade-change-requests/update/' . $gradeChangeRequest['id']) ?>" method="post" class="row">
            <div class="form-group col-6 col-md-4">
                <label for="original_points">Points</label>
                <input type="number" value="<?php echo $gradeChangeRequest['original_points'] ?>" name="original_points" class="form-control" id="original_points" readonly>
            </div>
            <div class="form-group col-6 col-md-4">
                <label for="original_grade">Grade</label>
                <input type="text" name="original_grade" value="<?php echo $gradeChangeRequest['original_grade'] ?>" class="form-control" id="original_grade" readonly>
            </div>
            <div class="form-group col-6 col-md-4">
                <label for="requested_points">Request Points</label>
                <input type="text" value="<?php echo $gradeChangeRequest['requested_points'] ?>" id="points" class="form-control" name="requested_points" required>
            </div>

            <div class="form-group col-6 col-md-4">
                <label for="requested_grade">Request Grade</label>
                <input type="text" value="<?php echo $gradeChangeRequest['requested_grade'] ?>" id="grade" class="form-control" name="requested_grade" readonly>
            </div>
            <div class="form-group col-6 col-md-4">
                <label for="reason">Reason</label>
                <textarea name="reason" id="reason" class="form-control" required placeholder="State valid Reason for Grade Change"><?php echo htmlspecialchars($gradeChangeRequest['reason']); ?></textarea>
            </div>
            <div class="form-group col-6 col-md-4">
                <label for="attachment">Attachment</label>
                <input type="file" name="attachment" id="attachment" class="" accept=".pdf, .doc, .docx, .txt">
            </div>
            <div class="form-group col-6 col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            <?php if (isset($_SESSION['error-message'])) : ?>
                <div class="form-group col-6 col-md-4 alert alert-danger">
                    <?php if (isset($_SESSION['error-message'])) {
                        echo $_SESSION['error-message'];
                        unset($_SESSION['error-message']);
                    } ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>