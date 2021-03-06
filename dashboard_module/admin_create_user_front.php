<!--
=========================================================
Material Dashboard - v2.1.2
=========================================================

Product Page: https://www.creative-tim.com/product/material-dashboard
Copyright 2020 Creative Tim (https://www.creative-tim.com)
Coded by Creative Tim

=========================================================
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<?php session_start(); 
        
  if (isset($_SESSION['update_response']) ) {
      $response = $_SESSION['update_response'];
      unset($_SESSION['update_response']);
  } else {
      $response = null;
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Material Dashboard by Creative Tim
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


<?php
    /*session_start();
    $test = "";

    if(isset($_SESSION["Reg_status_text"])) {
        //echo "<script> alert('".$_SESSION["Reg_status_text"]."'); </script>";
        $test = $_SESSION["Reg_status_text"];
        unset($_SESSION["Reg_status_text"]);
    }
    session_destroy();*/
?>

<body class="" onload="fetchUpdateResponse()">
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
                    <li class="nav-item">
                        <a class="nav-link" href="./dashboard.php">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./profile_details.php?id=<?php echo $curUser; ?>">
                            <i class="material-icons">person</i>
                            <p>My Profile</p>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="./admin_create_user_front.php">
                            <i class="material-icons">person_add</i>
                            <p>Create New User</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./create_event_front.php">
                            <i class="material-icons">emoji_events</i>
                            <p>Create New Event</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./user_list.php">
                            <i class="material-icons">content_paste</i>
                            <p>Users List</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./event_application_list.php">
                            <i class="material-icons">insert_drive_file</i>
                            <p>Event Applications List</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./team_list.php">
                            <i class="material-icons">people_alt</i>
                            <p>Team List</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./game_list.php">
                            <i class="material-icons">sports_esports</i>
                            <p>Games List</p>
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
                        <a class="navbar-brand" href="javascript:;">Create New User</a>
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
                                    <h4 class="card-title">New User Profile</h4>
                                    <p class="card-category">Fill in the details below to create a new user</p>
                                </div>
                                <div class="card-body">
                                    <br><br>
                                    <form action="admin_create_user_back.php" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="card-profile col-md-3">
                                                <div class="card-avatar">
                                                    <a href="javascript:;">
                                                        <img id="img_profile" class="img" src="../public/images/default.png"/>
                                                    </a>
                                                </div>
                                                    <br>
                                                <input type="file" id="fileToUpload" name="fileToUpload" accept="image/*" onchange="displayImg(this)">
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Full Name*</label>
                                                    <input type="text" class="form-control" name="name">
                                                </div>
                                                <br>
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">User ID*</label>
                                                    <input type="text" class="form-control" name="userid" required>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Date of Birth*</label>
                                                    <input placeholder="" class="form-control" type="text" onfocus="(this.type='date')" onblur="dateInputBehavior(this)" name="birthday" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                Gender*
                                                <select class="select2 form-control" name="gender" required>
                                                    <option value="M">Male</option>
                                                    <option value="F">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Phone Number* (eg 0123456789)</label>
                                                    <input type="tel" class="form-control" name="phone" pattern="01[0-9]{8,9}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Email Address*</label>
                                                    <input type="email" class="form-control" name="email" required>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">City*</label>
                                                    <input type="text" class="form-control" name="city" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                State*
                                                <select class="select2 form-control" name="state" required>
                                                    <option value="PERLIS">Perlis</option>
                                                    <option value="PERAK">Perak</option>
                                                    <option value="KEDAH">Kedah</option>
                                                    <option value="PENANG">Penang</option>
                                                    <option value="KELANTAN">Kelantan</option>
                                                    <option value="TERENGGANU">Terengganu</option>
                                                    <option value="PAHANG">Pahang</option>
                                                    <option value="SELANGOR">Selangor</option>
                                                    <option value="MELAKA">Melaka</option>
                                                    <option value="NEGERI SEMBILAN">Negeri Sembilan</option>
                                                    <option value="JOHOR">Johor</option>
                                                    <option value="SABAH">Sabah</option>
                                                    <option value="SARAWAK">Sarawak</option>
                                                    <option value="WILAYAH PERSEKUTUAN">Wilayah Persekutuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br><br><br>
                                        <span style="color: red;">* Fields are compulsory</span>
                                        <button style="inline-block" type="submit" class="btn btn-primary pull-right" name="submitBtn">Create New User</button>
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
    <div class="fixed-plugin">
        <div class="dropdown show-dropdown">
            <a href="#" data-toggle="dropdown">
                <i class="fa fa-cog fa-2x"> </i>
            </a>
            <ul class="dropdown-menu">
                <li class="header-title"> Sidebar Filters</li>
                <li class="adjustments-line">
                    <a href="javascript:void(0)" class="switch-trigger active-color">
                        <div class="badge-colors ml-auto mr-auto">
                            <span class="badge filter badge-purple" data-color="purple"></span>
                            <span class="badge filter badge-azure" data-color="azure"></span>
                            <span class="badge filter badge-green" data-color="green"></span>
                            <span class="badge filter badge-warning" data-color="orange"></span>
                            <span class="badge filter badge-danger" data-color="danger"></span>
                            <span class="badge filter badge-rose active" data-color="rose"></span>
                        </div>
                        <div class="clearfix"></div>
                    </a>
                </li>
                <li class="header-title">Images</li>
                <li class="active">
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="assets/img/sidebar-1.jpg" alt="">
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="assets/img/sidebar-2.jpg" alt="">
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="assets/img/sidebar-3.jpg" alt="">
                    </a>
                </li>
                <li>
                    <a class="img-holder switch-trigger" href="javascript:void(0)">
                        <img src="assets/img/sidebar-4.jpg" alt="">
                    </a>
                </li>
                <li class="button-container">
                    <a href="https://www.creative-tim.com/product/material-dashboard" target="_blank" class="btn btn-primary btn-block">Free Download</a>
                </li>
                <!-- <li class="header-title">Want more components?</li>
            <li class="button-container">
                <a href="https://www.creative-tim.com/product/material-dashboard-pro" target="_blank" class="btn btn-warning btn-block">
                  Get the pro version
                </a>
            </li> -->
                <li class="button-container">
                    <a href="https://demos.creative-tim.com/material-dashboard/docs/2.1/getting-started/introduction.html" target="_blank" class="btn btn-default btn-block">
            View Documentation
          </a>
                </li>
                <li class="button-container github-star">
                    <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star ntkme/github-buttons on GitHub">Star</a>
                </li>
                <li class="header-title">Thank you for 95 shares!</li>
                <li class="button-container text-center">
                    <button id="twitter" class="btn btn-round btn-twitter"><i class="fa fa-twitter"></i> &middot; 45</button>
                    <button id="facebook" class="btn btn-round btn-facebook"><i class="fa fa-facebook-f"></i> &middot; 50</button>
                    <br>
                    <br>
                </li>
            </ul>
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
    <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="assets/js/plugins/bootstrap-selectpicker.js"></script>
    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
    <script src="assets/js/plugins/jquery.dataTables.min.js"></script>
    <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
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
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chartist JS -->
    <script src="assets/js/plugins/chartist.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="assets/js/material-dashboard.js?v=2.1.2" type="text/javascript"></script>
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="assets/demo/demo.js"></script>
    <script type="text/javascript">
        function displayImg(input) {
            if (input.files && input.files[0]) {
                if(input.files[0].size > 2000000) {
                    Swal.fire({title: 'Failed!', html: "Image too large. Max image size 2MB !", type: 'error'});

                    return;
                }

                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img_profile')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
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
    <script type="text/javascript">
        function fetchUpdateResponse() {
            var response = "<?php echo $response; ?>";
            if(response == null || response == "") {

            } else {
                Swal.fire({title: 'Failed!', html: response, type: 'error'});
            }


        }
    </script>
</body>

</html>