<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center justify-content-between">
            <h3>Faculty</h3>
            <a href="<?php echo base_url('faculty/create'); ?>" class="btn btn-outline-primary">New Faculty Member</a>
        </div>
        <table class="table" style="overflow-x:auto">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Department</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $id = 1; ?>
                <?php foreach ($faculty as $faculty) : ?>
                    <tr>
                        <td><?php echo $id++; ?></td>
                        <td><?php echo $faculty['faculty_member_name']; ?></td>
                        <td><?php echo $faculty['role']; ?></td>
                        <td><?php echo $faculty['department_name']; ?></td>
                        <td>
                            <a href="<?php echo base_url('/faculty/edit/' . $faculty['id']); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                            <a href="<?php echo base_url('/faculty/delete/' . $faculty['id']); ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                        </td>
                    </tr>
                     <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>