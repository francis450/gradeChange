
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center justify-content-between">
            <h3>Users</h3>
            <a href="<?php echo base_url('users/create'); ?>" class="btn btn-outline-primary">Add User</a>
        </div>
        <table id="users" class="display responsive nowrap table main-content" style="overflow-x:auto">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $id = 1; ?>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?php echo $id++; ?></td>
                        <td><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['role']; ?></td>
                        <td>
                            <a href="<?php echo base_url('/users/edit/' . $user['id']); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                            <a href="<?php echo base_url('/users/delete/' . $user['id']); ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                        </td>
                    </tr>
                     <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        var table = new DataTable('#users', {
            searchable: true,
            sortable: true,
            select: true            
        });

        table.on('click', 'tbody tr', function(e) {
            e.currentTarget.classList.toggle('selected');
        });
    });
</script> 