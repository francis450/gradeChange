<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container" style="height: 100vh;">
        <div class="row mt-5 h-100">
            <div class="col-md-6 offset-md-3 row align-items-center">
                <div class="card p-0">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h5>SET NEW PASSWORD</h5>
                            </div>
                            <div class="col-6 text-end">
                                <a href="<?php echo base_url('login') ?>">Login</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo base_url('/new-password') ?>" method="post">
                            <div class="mb-3">
                                <!-- <label for="email" class="form-label">Email</label> -->
                                <input type="email" name="email" id="email" value="<?php echo $email ?>" class="form-control d-none" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                            </div>
                            <?php if (isset($_SESSION['error-message'])) : ?>
                                <div class="form-group col-12 alert alert-danger">
                                    <?php if (isset($_SESSION['error-message'])) {
                                        echo $_SESSION['error-message'];
                                        unset($_SESSION['error-message']);
                                    } ?>
                                </div>
                            <?php endif; ?>
                            <div class="mb-3"></div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>