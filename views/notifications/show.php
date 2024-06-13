
<div class="card mt-2">
    <div class="card-header">
        <h4>Notification</h4>
    </div>
    <div class="card-body">
        <h5 class="card-title"><?php echo $notification['type']; ?></h5>
        <p class="card-text"><?php echo $notification['message']; ?></p>
        <a href="<?php echo base_url('/notifications'); ?>" class="btn btn-primary">Back</a>
    </div>
</div>

