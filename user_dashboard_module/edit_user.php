<?php
  include '../public/DBconnect.php';

  session_start();
  $con = DatabaseConn();
  $userID = $_SESSION["Curr_user"];

  // fetch user id
  $sql_detail = "SELECT * FROM `users` WHERE `id` = '$userID'";

  $account_details = mysqli_query($con, $sql_detail);
  $details = mysqli_fetch_array($account_details);

  // assign variable
  $name = $details[1];
  $user_id = $details[2];
  $mobile_number = $details[3];
  $email = $details[4];
  $DoB = $details[6];
  $gender = $details[7];
  $status = $details[8];
  $city = $details[11];
  $state = $details[12];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Edit Details
    </title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!-- Bootstrap Select CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-select.min.css">
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="assets/css/material-dashboard.css" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="assets/demo/demo.css" rel="stylesheet" />

    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->  
</head>

<body class="">
    <div class="wrapper ">
        <div class="sidebar" data-color="purple" data-background-color="white" data-image="assets/img/sidebar-1.jpg">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
            <div class="logo"><a href="http://www.creative-tim.com" class="simple-text logo-normal">
          Creative Tim
        </a></div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="nav-item  ">
                        <a class="nav-link" href="./dashboard.php">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./user.html">
                            <i class="material-icons">person</i>
                            <p>User Profile</p>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="./admin_create_user_front.php">
                            <i class="material-icons">person_add</i>
                            <p>Create New User</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./tables.html">
                            <i class="material-icons">content_paste</i>
                            <p>Table List</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./typography.html">
                            <i class="material-icons">library_books</i>
                            <p>Typography</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./icons.html">
                            <i class="material-icons">bubble_chart</i>
                            <p>Icons</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./map.html">
                            <i class="material-icons">location_ons</i>
                            <p>Maps</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./notifications.html">
                            <i class="material-icons">notifications</i>
                            <p>Notifications</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./rtl.html">
                            <i class="material-icons">language</i>
                            <p>RTL Support</p>
                        </a>
                    </li>
                    <li class="nav-item active-pro ">
                        <a class="nav-link" href="./upgrade.html">
                            <i class="material-icons">unarchive</i>
                            <p>Upgrade to PRO</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <a class="navbar-brand" href="javascript:;">Edit user profile</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:;">
                                    <i class="material-icons">dashboard</i>
                                    <p class="d-lg-none d-md-block">
                                        Stats
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">notifications</i>
                                    <span class="notification">5</span>
                                    <p class="d-lg-none d-md-block">
                                        Some Actions
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="#">Mike John responded to your email</a>
                                    <a class="dropdown-item" href="#">You have 5 new tasks</a>
                                    <a class="dropdown-item" href="#">You're now friend with Andrew</a>
                                    <a class="dropdown-item" href="#">Another Notification</a>
                                    <a class="dropdown-item" href="#">Another One</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">person</i>
                                    <p class="d-lg-none d-md-block">
                                        Account
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                    <a class="dropdown-item" href="#">Profile</a>
                                    <a class="dropdown-item" href="#">Settings</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Log out</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-11">
                            <div class="card">
                                <div class="card-header card-header-primary">
                                    <h4 class="card-title">Edit User</h4>
                                    <p class="card-category">Fill in details below to update user profile</p>
                                </div>
                                <div class="card-body">
                                    <br><br>
                                    <!-- <form action="admin_create_user_back.php" method="post"> -->
                                    <form id="createUserForm">
                                        <div class="row">
                                            <div class="card-profile col-md-3">
                                                <div class="card-avatar">
                                                    <a href="javascript:;">
                                                        <img class="img" src="assets/img/faces/marc.jpg" />
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Full Name</label>
                                                    <input type="text" class="form-control" name="name" 
                                                     value="<?php echo $name ?>" required>
                                                </div>
                                                    <input type="hidden" name="user_id" 
                                                     value="<?php echo $userID ?>" required>
                                                <br>
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">User ID</label>
                                                    <input type="text" class="form-control" name="userid" value="<?php echo $user_id ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Date of Birth</label>
                                                    <input placeholder="" class="form-control" type="text" onfocus="(this.type='date')" onblur="dateInputBehavior(this)" name="birthday"
                                                    value="<?php echo $DoB ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                Gender
                                                <select class="select2 form-control" name="gender" required>
                                                    <option value="male" <?php if ($gender == 'male') echo ' selected="selected"'; ?>>Male</option>
                                                    <option value="female" <?php if ($gender == 'female') echo ' selected="selected"'; ?>>Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Phone Number (eg 0123456789)</label>
                                                    <input type="tel" class="form-control" name="phone" value="<?php echo $mobile_number ?>" pattern="01[0-9]{8,9}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Email Address</label>
                                                    <input type="email" class="form-control" name="email" value="<?php echo $email ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">City</label>
                                                    <input type="text" class="form-control" name="city" value="<?php echo $city ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                State
                                                <select class="select2 form-control" name="state" required>
                                                    <option value="PERLIS" <?php if ($state == 'PERLIS') echo ' selected="selected"'; ?>>Perlis</option>
                                                    <option value="PERAK" <?php if ($state == 'PERAK') echo ' selected="selected"'; ?>>Perak</option>
                                                    <option value="KEDAH" <?php if ($state == 'KEDAH') echo ' selected="selected"'; ?>>Kedah</option>
                                                    <option value="PENANG" <?php if ($state == 'PENANG') echo ' selected="selected"'; ?>>Penang</option>
                                                    <option value="KELANTAN" <?php if ($state == 'KELANTAN') echo ' selected="selected"'; ?>>Kelantan</option>
                                                    <option value="TERENGGANU" <?php if ($state == 'TERENGGANU') echo ' selected="selected"'; ?>>Terengganu</option>
                                                    <option value="PAHANG" <?php if ($state == 'PAHANG') echo ' selected="selected"'; ?>>Pahang</option>
                                                    <option value="SELANGOR" <?php if ($state == 'SELANGOR') echo ' selected="selected"'; ?>>Selangor</option>
                                                    <option value="MELAKA" <?php if ($state == 'MELAKA') echo ' selected="selected"'; ?>>Melaka</option>
                                                    <option value="NEGERI SEMBILAN" <?php if ($state == 'NEGERI SEMBILAN') echo ' selected="selected"'; ?>>Negeri Sembilan</option>
                                                    <option value="JOHOR" <?php if ($state == 'JOHOR') echo ' selected="selected"'; ?>>Johor</option>
                                                    <option value="SABAH" <?php if ($state == 'SABAH') echo ' selected="selected"'; ?>>Sabah</option>
                                                    <option value="SARAWAK" <?php if ($state == 'SARAWAK') echo ' selected="selected"'; ?>>Sarawak</option>
                                                    <option value="WILAYAH PERSEKUTUAN" <?php if ($state == 'WILAYAH PERSEKUTUAN') echo ' selected="selected"'; ?>>Wilayah Persekutuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br><br><br>
                                        <button type="submit" class="btn btn-primary pull-right" name="submitBtn">Save User</button>
                                        <button type="button" class="btn btn-danger pull-left" name="submitBtn" onclick="deleteUser(<?php echo $userID ?>)" <?php if ($status == 'authenticated') echo ' hidden'; ?>>Delete User</button>
                                        <button type="button" class="btn btn-warning pull-right" name="btnCancel" onclick="redirectBack()">Back</button>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <nav class="float-left">
                        <ul>
                            <li>
                                <a href="https://www.creative-tim.com">
                                    Creative Tim
                                </a>
                            </li>
                            <li>
                                <a href="https://creative-tim.com/presentation">
                                    About Us
                                </a>
                            </li>
                            <li>
                                <a href="http://blog.creative-tim.com">
                                    Blog
                                </a>
                            </li>
                            <li>
                                <a href="https://www.creative-tim.com/license">
                                    Licenses
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="copyright float-right">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>, made with <i class="material-icons">favorite</i> by
                        <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a> for a better web.
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap-material-design.min.js"></script>
    <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!-- Plugin for the momentJs  -->
    <script src="assets/js/plugins/moment.min.js"></script>
    <!--Select2 JS -->
    <script src="vendor/select2/select2.min.js" type="text/javascript"></script>
    <!--DateRangePicker JS -->
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <!--  Plugin for Sweet Alert -->
    <script src="assets/js/plugins/sweetalert2.js"></script>
    <!-- Forms Validations Plugin -->
    <script src="assets/js/plugins/jquery.validate.min.js"></script>
    <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <script src="assets/js/plugins/jquery.bootstrap-wizard.js"></script>
    <!--    Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="assets/js/plugins/bootstrap-selectpicker.js"></script>
    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
    <script src="assets/js/plugins/jquery.dataTables.min.js"></script>
    <!--    Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
    <script src="assets/js/plugins/bootstrap-tagsinput.js"></script>
    <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="assets/js/plugins/jasny-bootstrap.min.js"></script>
    <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
    <script src="assets/js/plugins/fullcalendar.min.js"></script>
    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <script src="assets/js/plugins/jquery-jvectormap.js"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="assets/js/plugins/nouislider.min.js"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <!-- Library for adding dinamically elements -->
    <script src="assets/js/plugins/arrive.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="assets/js/material-dashboard.js?v=2.1.2" type="text/javascript"></script>
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="assets/demo/demo.js"></script>
    <script>
        function redirectBack() {
          window.location.replace("user_list.php");
        }
    </script>
    <script>
        function dateInputBehavior(e) {
            if (e.value == "" || e.value == null) {
                e.type = "text"; //Change input back to text to remove 'dd/mm/yyyy' placeholder
            } else {
                e.type = "date";
            }
        }
    </script>
</body>

</html>