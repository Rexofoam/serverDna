<?php
  include '../public/DBconnect.php';

  session_start();
  $con = DatabaseConn();
  $userID = $_SESSION['Curr_user'];
  $gameOptions = "";

  $sql_user = mysqli_fetch_array(mysqli_query($con, "SELECT email FROM users WHERE id = '$userID'"));
  $cur_user_email = $sql_user['email'];

  //Game options
  $sql_games = mysqli_query($con,"SELECT game_id, game_name FROM games");
  while($row = mysqli_fetch_array($sql_games)) {
    $gameOptions .= '<option value="'.$row['game_id'].'">'.$row['game_name'].'</option>';
  }

  $help_msg = "Each member can only be assigned to one role. Only the captain and vice-captain can make changes to the team after creation.<br><br>All of the members listed below (except yourself) will receive an invitation to join the team.";
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
                        <a class="navbar-brand" href="javascript:;">Teams</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end">
                        <form class="navbar-form">
                            <div class="input-group no-border">
                                <input type="text" value="" class="form-control" placeholder="Search...">
                                <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                    <i class="material-icons md-light">search</i>
                                    <div class="ripple-container"></div>
                                </button>
                            </div>
                        </form>
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
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-primary">
                                    <h4 class="card-title">New Team</h4>
                                    <p class="card-category">Create a team and add members for convenient tournament registration!</p>
                                </div>
                                <div class="card-body">
                                    <br>
                                    <form id="createTeamForm">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Team Name*</label>
                                                    <input type="text" class="form-control" name="team_name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="select2 select2-game form-control" name="games" multiple="multiple">
                                                    <?php echo $gameOptions; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <br><br>
                                        <h4 style="display: inline-block;">Team Members</h4>
                                        <div style="display: inline-block;">
                                            <button class="icon-button" type="button" onclick="md.showNotification('top','right', '<?php echo $help_msg; ?>')"><i class="material-icons" style="font-size:20px;">help</i></button>
                                        </div>
                                        <br>
                                        Enter the <b>EMAIL ADDRESS(ES)</b> of <b>existing</b> users in their respective roles (Captain, Vice-captain, etc..) below to invite them to the team.<br>
                                        You can invite multiple members in the <b>Players</b> and <b>Substitutes</b> roles. Press <b>ENTER</b> or <b>SPACE</b> to finish entering an email address.<br>
                                        All inputs are CaSe SeNsItIvE
                                        <br><br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                Team Captain*
                                                <select class="select2 select2-member form-control" name="team_capt" required>
                                                    <option value='<?php echo $cur_user_email; ?>'><?php echo $cur_user_email; ?></option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                Team Vice-Captain
                                                <select class="select2 select2-member form-control" name="team_vice">
                                                    <option value=' '>None</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                Players*
                                                <select class="select2 select2-member form-control" name="team_members" multiple="multiple" required>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                Substitutes
                                                <select class="select2 select2-member form-control" name="team_subs" multiple="multiple">
                                                </select>
                                            </div>
                                        </div>
                                        <br><br>
                                        <span style="color: red;">* Fields are compulsory</span>
                                        <button style="inline-block" type="submit" class="btn btn-primary pull-right" name="submitBtn">Create Team</button>
                                        <button style="inline-block" type="button" class="btn btn-warning pull-right" name="btnBack">Back</button>
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
        $(document).ready(function() {
            $('.select2').select2();

            $('.select2-game').select2({
                placeholder: 'Please select the game(s) your team plays'
            });

            $('.select2-member').select2({
                placeholder: 'Please enter the email address of members you wish to invite to the team',
                tags: true,
                tokenSeparators: [' '],
                "language": {
                    "noResults": function(){
                        return "Type out the email address of members you wish to invite in this role, finish typing by pressing SPACE or ENTER.";
                    }
                }
            });

            $(document).on('submit', '#createTeamForm', function() {
                // do not refresh form on submit so that notifications can be shown
                return false;
            });

            $(":button[name='btnBack']").click(function(){
                window.location.replace("team_list.php");
            });

            $(":button[name='submitBtn']").click(function(){
                var team_name = $("input[name='team_name']").val();
                var games = $("select[name='games']").val();
                var team_capt = $("select[name='team_capt']").val();
                var team_vice = $("select[name='team_vice']").val();
                var team_members = $("select[name='team_members']").val();
                var team_subs = $("select[name='team_subs']").val();
                var created_by = '<?php echo $userID; ?>';

                if (team_name != "" && team_capt != "" && team_members != "") {
                    $.ajax({
                        url: 'team_create_back.php',
                        type: 'POST',
                        data: {team_name : team_name, games: games, team_capt: team_capt,
                               team_vice: team_vice, team_members: team_members, team_subs: team_subs,
                               created_by: created_by},
                        success: function(res) {
                            var data = JSON.parse(res);

                            if (data['statusCode'] == 1) { //'1' is set as code for successful registration
                                Swal.fire({title: 'Success!', html: data['msg'], 
                                    type: 'success'}).then(function(){
                                        window.location.replace("team_list.php");
                                    });
                            } else {
                                Swal.fire({title: 'Error!', html: data['msg'], type: 'error'});
                            }
                        },
                        error: function(res) {
                            Swal.fire({title: 'Error!', html: 'We were unable to complete the operation.<br>Please try again later', type: 'error'});
                        }
                        });
                }
            });
        });
    </script>
</body>

</html>