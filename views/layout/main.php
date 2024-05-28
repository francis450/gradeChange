<?php
function generateSidebarLinks($role)
{
    $links = [
        'common' => [
            'Dashboard' => base_url('/dashboard'),
            'Notifications' => base_url('/notifications'),
        ],
        'student' => [
            'Courses' => base_url('/courses'),
            'Grades' =>  base_url('/grades'),
            'My Grade Change Requests' =>  base_url('/grade-change-requests'),
        ],
        'faculty_member' => [
            'Courses' => base_url('/courses'),
            'Grades' => base_url('/grades'),
            'Grade Change Requests' => base_url('/grade-change-requests'),
            'Students' => base_url('/students'),
        ],
        'department_head' => [
            'Courses' => base_url('/courses'),
            'Grades' => base_url('/grades'),
            'Grade Change Requests' => base_url('/grade-change-requests'),
            'Students' => base_url('/students'),
        ],
        'chairman' => [
            'Departments' => base_url('/departments'),
            'Students' => base_url('/students'),
            'Courses' => base_url('/courses'),
            'Grade Change Requests' => base_url('/grade-change-requests'),
        ],
        'finance_head' => [
            'Departments' => base_url('/departments'),
            'Students' => base_url('/students'),
            'Courses' => base_url('/courses'),
            'Grades' => base_url('/grades'),
            'Grade Change Requests' => base_url('/grade-change-requests'),
        ],
        'admin' => [
            'Departments' => base_url('/departments'),
            'Students' => base_url('/students'),
            'Courses' => base_url('/courses'),
            'Grades' => base_url('/grades'),
            'Grade Change Requests' => base_url('/grade-change-requests'),
            'Users' => base_url('/users')
        ],
    ];

    $menuItems = $links['common'];

    if (isset($links[$role])) {
        $menuItems = array_merge($menuItems, $links[$role]);
    }

    $currentPath = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    foreach ($menuItems as $title => $url) {
        $normalizedUrl = rtrim(parse_url($url, PHP_URL_PATH), '/');
        $activeClass = ($currentPath == $normalizedUrl) ? 'active' : '';
        echo "<a href=\"$url\" class=\"list-group-item list-group-item-action $activeClass\">$title</a>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'My Application'; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo base_url('/assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('/assets/css/datatable.css') ?>">
</head>

<body>
    <div class="container-fluid">
        <!-- Navigation bar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto d-none d-sm-flex">
                    <li class="nav-item mr-1 xs-d-none d-sm-flex">
                        <a class="nav-link btn btn-outline-primary" href="#">Profile</a>
                    </li>
                    <li class="nav-item xs-d-none d-sm-flex">
                        <a class="nav-link btn btn-outline-danger logout" href="#">Logout</a>
                    </li>
                </ul>
                <div class="list-group d-sm-none">
                    <?php generateSidebarLinks($_SESSION['role']); ?>
                </div>
            </div>
        </nav>

        <!-- Dashboard Content -->
        <div class="row mt-4">
            <div class="col-md-3 ">
                <!-- Sidebar -->
                <div class="list-group d-none d-sm-block">
                    <?php generateSidebarLinks($_SESSION['role']); ?>
                </div>
            </div>
            <div class="col-md-9">
                <!-- Main Content -->
                <?php echo $content; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom JS -->
    <script src="<?php echo base_url('/assets/js/formSubmission.js') ?>"></script>
    <script src="<?php echo base_url('/assets/js/datatable.js') ?>"></script>
</body>

</html>
