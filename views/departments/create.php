<div class="container">
    <h3>New Department</h3>
    <form class="row" action="<?php echo base_url('departments/store'); ?>" method="post">
        <div class="form-group col-6 col-md-4">
            <label for="name">Department Name:</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="form-group col-6 col-md-4">
            <label for="department_head">Department Head:</label>
            <?php
                echo '<pre>';
                print_r($faculty);
                echo '<pre>';
            ?>
        </div>
        <div class="form-group col-6 col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-outline-primary ">SAVE</button>
        </div>
    </form>
</div>