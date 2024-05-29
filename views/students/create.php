<div class="container">
    <h3>Add New Student</h3>
    <form class="row" action="<?php echo base_url('students/store'); ?>" method="post">
        <div class="form-group col-6 col-md-4">
            <label for="user_id">User</label>
            <select name="user_id" class="form-control">
                <?php foreach ($users as $user) : ?>
                    <option value="<?php echo $user['id']; ?>"><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-6 col-md-4">
            <label for="department_id">Department</label>
            <select name="department_id" class="form-control">
                <?php foreach ($departments as $department) : ?>
                    <option value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
       
        <div class="form-group col-6 col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-outline-primary ">SAVE</button>
        </div>
    </form>
</div>