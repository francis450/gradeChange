<div class="container">
    <h3>Edit Department</h3>
    <form class="row" action="<?php echo base_url('departments/update/' . $department['id']); ?>" method="post">

        <div class="form-group col-6 col-md-4">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" value="<?php echo $department['name']; ?>" required>
        </div>
        
        <div class="form-group col-6 col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-outline-primary ">UPDATE</button>
        </div>
    </form>
</div>