
<div class="container">
    <h3>Edit Faculty Member Details</h3>
    <form class="row" action="<?php echo base_url('faculty/update/' . $faculty['id']); ?>" method="post">

        <div class="form-group col-6 col-md-4">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control">
                <option value="">Select Role</option>
                <option value="department head" <?php if ($faculty['role'] == 'department head') {
                                                    echo 'selected';
                                                } ?>>Department Head</option>
                <option value="finance head" <?php if ($faculty['role'] == 'finance head') {
                                                    echo 'selected';
                                                } ?>>Finance Head</option>
                <option value="chairman" <?php if ($faculty['role'] == 'chairman') {
                                                    echo 'selected';
                                                } ?>>chairman</option>
           
                <option value="faculty member" <?php if ($faculty['role'] == 'regular faculty') {
                                                    echo 'selected';
                                                } ?>>Regular Faculty Member
                </option>
            </select>
        </div>

        <div class="form-group col-6 col-md-4">
            <label for="department">Department</label>
            <select name="department" id="department" class="form-control">
                <option value="">Select Department</option>
                <?php foreach ($department as $department) : ?>
                    <option value="<?php echo $department['id']; ?>" <?php if ($faculty['department_id'] == $department['id']) {
                                                                            echo 'selected';
                                                                        } ?>><?php echo $department['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-6 col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-outline-primary ">UPDATE</button>
        </div>
    </form>
</div>