<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center justify-content-between">
            <h3>Departments</h3>
            <a href="<?php echo base_url('departments/create'); ?>" class="btn btn-outline-primary">New Department</a>
        </div>
        <table class="table mt-2" style="overflow-x:auto">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Department Head</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $id = 1; ?>
                <?php foreach ($departments as $department) : ?>
                    <tr>
                        <td><?php echo $id++; ?></td>
                        <td><?php echo $department['name']; ?></td>
                        <td><?php echo $department['department_head']; ?></td>
                        <td>
                            <a href="<?php echo base_url('/departments/edit/' . $department['id']); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                            <a href="<?php echo base_url('/departments/delete/' . $department['id']); ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                        </td>
                    </tr>
                     <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>