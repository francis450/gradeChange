<div class="container">
    <h1>Edit User</h1>
    <form class="row" action="<?php echo base_url('users/update/' . $user['id']); ?>" method="post">

        <div class="form-group col-6 col-md-4">
            <label for="name">First Name:</label>
            <input type="text" class="form-control" name="firstname" value="<?php echo $user['firstname']; ?>" required>
        </div>
        <div class="form-group col-6 col-md-4">
            <label for="name">Last Name:</label>
            <input type="text" class="form-control" name="lastname" value="<?php echo $user['lastname']; ?>" required>
        </div>
        <div class="form-group col-6 col-md-4">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>" required>
        </div>
        <div class="form-group col-6 col-md-4">
            <label for="role">Role:</label>
            <select name="role" class="form-control">
                <option value="admin" <?php if ($user['role'] == 'admin') {
                                            echo 'selected';
                                        } ?>>Admin
                </option>
                <option value="chairman" <?php if ($user['role'] == 'chairman') {
                                                echo 'selected';
                                            } ?>>Chairman
                </option>
                <option value="finance head" <?php if ($user['role'] == 'finance head') {
                                                    echo 'selected';
                                                } ?>>Finance Head
                </option>
                <option value="departmnet head" <?php if ($user['role'] == 'department head') {
                                                    echo 'selected';
                                                } ?>>Department Head
                </option>
                <option value="faculty member" <?php if ($user['role'] == 'faculty member') {
                                                    echo 'selected';
                                                } ?>>Faculty Member
                </option>
                <option value="student" <?php if ($user['role'] == 'student') {
                                            echo 'selected';
                                        } ?>>Student
                </option>
                <option value="user" <?php if ($user['role'] == 'user') {
                                            echo 'selected';
                                        } ?>>User
                </option>
            </select>
        </div>
        <div class="form-group col-6 col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-outline-primary ">UPDATE</button>
        </div>
    </form>
</div>