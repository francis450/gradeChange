<div class="container">
    <h3>New Faculty Member</h3>
    <form class="row" action="<?php echo base_url('faculty/store'); ?>" method="post">
        <div class="form-group col-6 col-md-4">
            <label for="name">Name</label>
            <select name="name" id="name" class="form-control">
                <option value="">Select User</option>
                <?php foreach($users as $user): ?>
                    <option value="<?php echo $user['id']; ?>"><?php echo $user['firstname']." ".$user['lastname']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-6 col-md-4">
            <label for="department">Department</label>
            <select name="department" id="department" class="form-control">
                <option value="">Select Department</option>
                <?php foreach($departments as $department): ?>
                    <option value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-6 col-md-4">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control">
                <option value="">Select Role</option>
                <option value="regular faculty">Faculty Member</option>
                <option value="department head">Department Head</option>
                <option value="finance head">Finance Head</option>
                <option value="chairman">chairman</option>
            </select>
        </div>
        <div class="form-group col-6 col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-outline-primary ">SAVE</button>
        </div>
    </form>
</div>
