
<div class="container">
    <h4>Edit <?php echo $course['name'] ?></h4>
    <form class="row" action="<?php echo base_url('courses/update/'.$course['id']); ?>" method="post">
        <div class="form-group col-6 col-md-4">
            <label for="name">Course Name:</label>
            <input type="text" class="form-control" name="name" value="<?php echo $course['name'] ?>"  required>
        </div>
        <div class="form-group col-6 col-md-4">
            <label for="department_id">Department</label>
            <select name="department_id" id="deoartment_id" class="form-control">
                <option value="">Select Department</option>
                <?php foreach ($departments as $department) : ?>
                    <option value="<?php echo $department['id']; ?>" <?php if($department['id'] == $course['department_id']){echo 'selected';} ?> ><?php echo $department['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-6 col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-outline-primary ">SAVE</button>
        </div>
    </form>
</div>