<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center justify-content-between">
            <h3>Notifications</h3>
        </div>
    </div>
    <table class="table" style="overflow-x:auto">
        <thead>
            <tr>
                <th>#</th>
                <th>Message</th>
                <th>Sent At</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $id = 1; ?>
            <?php foreach ($notifications as $notification) : ?>
                <tr>
                    <td><?php echo $id++; ?></td>
                    <td><?php echo $notification['message']; ?></td>
                    <td><?php echo $notification['created_at']; ?></td>
                    <td>
                        <a href="<?php echo base_url('/notifications/mark-as-read/' . $notification['id']); ?>" class="btn btn-sm btn-outline-primary">Mark as Read</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>