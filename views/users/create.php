<div class="container">
    <h3>Add New User</h3>
    <form class="row" action="<?php echo base_url('users/store'); ?>" method="post">
        <div class="form-group col-6 col-md-4">
            <label for="name">First Name:</label>
            <input type="text" class="form-control" name="firstname" required>
        </div>
        <div class="form-group col-6 col-md-4">
            <label for="name">Last Name:</label>
            <input type="text" class="form-control" name="lastname" required>
        </div>
        <div class="form-group col-6 col-md-4">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="form-group col-6 col-md-4">
            <label for="role">Role:</label>
            <select name="role" class="form-control">
                <option value="admin">Admin</option>
                <option value="chairman">Chairman</option>
                <option value="finance head">Finance Head </option>
                <option value="departmnet head">Department Head</option>
                <option value="faculty member" >Faculty Member</option>
                <option value="student" >Student </option>
            </select>
        </div>
        <div class="form-group col-6 col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-outline-primary ">SAVE</button>
        </div>
    </form>
</div>