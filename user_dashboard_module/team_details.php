<?php
  include '../public/DBconnect.php';

  session_start();
  $con = DatabaseConn();
  $userID = $_SESSION['Curr_user'];
  $teamID = $_GET['id'];

  // fetch all game details
  $sql_games = "SELECT `game_id`, `game_name` FROM `games`";
  $games = mysqli_fetch_all(mysqli_query($con, $sql_games), MYSQLI_ASSOC);

  // fetch team details
  $sql_detail = "SELECT t.`team_name`, t.`games`, t.`created_at`, u.`full_name`
                 FROM `teams` t JOIN `users` u ON t.`created_by` = u.`id` WHERE t.`team_id` = '$teamID'";
  $details = mysqli_fetch_array(mysqli_query($con, $sql_detail));

  // assign variable
  $team_name = $details['team_name'];
  $games_arr = explode(",", $details['games']);
  $created_at = date("d F Y", strtotime($details['created_at']));
  $created_by = $details['full_name'];
  $games_list = "";

  // Transform list of games from ID list (1,4,5) to name list (Dota, LoL, CSGO)
  foreach ($games_arr as $game) {
    if ($games_list == "") $games_list .= $games[array_search($game, array_column($games, 'game_id'))]['game_name'];
    else $games_list .= ", ".$games[array_search($game, array_column($games, 'game_id'))]['game_name'];
  }

  // fetch team member details
  $sql_capt = "SELECT ut.`user_id`, u.`full_name`, u.`image_url`,ut.`role`, ut.`status` 
                FROM `user_teams` ut JOIN `users` u ON ut.`user_id` = u.`id`
                WHERE ut.`team_id` = '$teamID' AND ut.`role` = 'captain'";
  $capt = mysqli_fetch_array(mysqli_query($con, $sql_capt));

  if($capt['image_url'] == null) {
    $capt['image_url'] = "../public/images/default.png";
  }

  $sql_vice = "SELECT ut.`user_id`, u.`full_name`, u.`image_url`, ut.`role`, ut.`status` 
                FROM `user_teams` ut JOIN `users` u ON ut.`user_id` = u.`id`
                WHERE ut.`team_id` = '$teamID' AND ut.`role` = 'vice'";
  $vice = mysqli_fetch_array(mysqli_query($con, $sql_vice));

  if($vice['image_url'] == null) {
    $vice['image_url'] = "../public/images/default.png";
  }

  $sql_player = "SELECT ut.`user_id`, u.`full_name`, u.`image_url`, ut.`role`, ut.`status` 
                FROM `user_teams` ut JOIN `users` u ON ut.`user_id` = u.`id`
                WHERE ut.`team_id` = '$teamID' AND ut.`role` = 'player'";
  $player = mysqli_fetch_all(mysqli_query($con, $sql_player), MYSQLI_ASSOC);

  $playerCount = sizeof($player);
  $playerHTML = generateSectionHTML($player);

  $sql_sub = "SELECT ut.`user_id`, u.`full_name`, u.`image_url`, ut.`role`, ut.`status` 
                FROM `user_teams` ut JOIN `users` u ON ut.`user_id` = u.`id`
                WHERE ut.`team_id` = '$teamID' AND ut.`role` = 'substitute'";
  $sub = mysqli_fetch_all(mysqli_query($con, $sql_sub), MYSQLI_ASSOC);

  $subCount = sizeof($sub);
  $subHTML = generateSectionHTML($sub);

  // Only captain and vice captain can edit team
  $canEdit = false;
  if ($userID == $capt['user_id'] || (isset($vice) && sizeof($vice) > 0 && $userID == $vice['user_id'])) {
    $canEdit = true;
  }

  // function to generate html for a section
  function generateSectionHTML($member_arr) {
    $ctr = 0;
    $memberCnt = sizeof($member_arr);
    $html = "";

    foreach($member_arr as $m) {
        $newRow = $endRow = false;

        //Print a new row for every 2 members
        if ($ctr % 2 == 0) $html .= '<div class="row">';

        $html .= generateMemberHTML($m['full_name'], $m['role'], $m['status'], $m['image_url']);

        if ($ctr % 2 == 1) $html .= '</div><br><br>';
        $ctr++;
    }

    if ($memberCnt % 2 == 1) $html .= '</div>'; //End row early if there's an odd number of members
    
    return $html;
  }

  // function to generate html for a single member
  function generateMemberHTML($full_name, $role, $status, $image) {
    $html = "";
    $statusText = "";

    if ($status == 'pending') $statusText = ' <b style="color:red;">(PENDING INVITE)</b>';

    $html .= '<div class="card-profile col-md-2">
                    <div class="card-avatar">
                        <img class="img" src="' . $image_url = ($image == null ? '../public/images/default.png' : $image)  . '"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <h6 class="card-category">'.strtoupper($role).'</h6>
                    <label style="color: black">'.$full_name.$statusText.'</label>
                </div>';

    return $html;
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
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header card-header-primary">
                                    <h4 class="card-title">Team Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <div class="form-group">
                                                <h6 class="card-category">Team Name</h6>
                                                <label style="color: black"><?php echo $team_name;?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-11">
                                            <div class="form-group">
                                                <h6 class="card-category">Games</h6>
                                                <label style="color: black"><?php echo $games_list;?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <h6 class="card-category">Created by</h6>
                                                <label style="color: black"><?php echo $created_by;?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <h6 class="card-category">Date of Creation</h6>
                                                <label style="color: black"><?php echo $created_at;?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <?php if ($canEdit) echo '<button type="button" class="btn btn-primary pull-right" onclick="edit('.$teamID.')" name="editBtn">Edit Team</button>'; ?>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="card">
                                    <div class="card-header card-header-primary">
                                        <h4 class="card-title">Captains</h4>
                                    </div>
                                    <div class="card-body">
                                        <br><br>
                                        <div class="row">
                                            <div class="card-profile col-md-2">
                                                <div class="card-avatar">
                                                    <img width="10" height="10" class="img" src="<?php echo $capt['image_url'] ?>" onerror=this.src="../public/images/default.png"/>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h6 class="card-category">CAPTAIN</h6>
                                                <label style="color: black"><?php echo $capt['full_name'];?></label>
                                            </div>
                                            <div class="card-profile col-md-2">
                                                <div class="card-avatar">
                                                    <img width="10" height="10" class="img" src="<?php echo $vice['image_url'] ?>" onerror=this.src="../public/images/default.png"/>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h6 class="card-category">VICE CAPTAIN</h6>
                                                <?php if (isset($vice) && sizeof($vice) > 0) {
                                                    if ($vice['status'] == 'pending') {
                                                        echo '<label style="color: black">'.$vice['full_name'].'<b style="color:red;"> (PENDING INVITE)</b></label>';
                                                    } else {
                                                        echo '<label style="color: black">'.$vice['full_name'].'</label>';
                                                    }
                                                } else {
                                                    echo '<label style="color: black">None</label>';
                                                } ?>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="card">
                                    <div class="card-header card-header-primary">
                                        <h4 class="card-title">Players</h4>
                                        <p class="card-category">Player Count: <?php echo $playerCount; ?></p>
                                    </div>
                                    <div class="card-body">
                                        <br><br>
                                        <?php echo $playerHTML; ?>
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="card">
                                    <div class="card-header card-header-primary">
                                        <h4 class="card-title">Substitutes</h4>
                                        <p class="card-category">Sub Count: <?php echo $subCount; ?></p>
                                    </div>
                                    <div class="card-body">
                                        <br><br>
                                        <?php echo $subHTML; ?>
                                        <br>
                                    </div>
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
    function edit(id) {
        var edit_url = "team_edit_front.php"

        // redirect to edit page
        window.location.href = edit_url + "?id=" + id;
    }
    </script>
</body>

</html>