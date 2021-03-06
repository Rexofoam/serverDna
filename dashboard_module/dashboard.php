<?php
    include '../public/DBconnect.php';

    session_start();
    $con = DatabaseConn();
    $curUser = $_SESSION['Curr_user'];

    $date = new DateTime();
	$date->add(new DateInterval('PT06H'));
    $AccessTime = $date->format('Y-m-d');

    //Data for top section (total users, applications, teams, etc) -------------------------------------------------------------------------------------------------
    $admin_count = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) FROM `users` WHERE `is_admin` = '1' AND `status` = 'authenticated'"));
    $admin_list = mysqli_query($con, "SELECT `full_name`,`user_id`, `email`,`mobile_number` FROM `users` WHERE `is_admin` = '1' AND `status` = 'authenticated'");

    $sql_users = "SELECT COUNT(*) FROM `users` WHERE `is_admin` = '0' AND `status` = 'authenticated'";
    $sql_pending_users = "SELECT COUNT(*) FROM `users` WHERE `is_admin` = '0' AND `status` != 'authenticated'";
    $sql_admin = "SELECT COUNT(*) FROM `users` WHERE `is_admin` = '1'";

    $sql_app = "SELECT COUNT(*) FROM `event_application` WHERE `status` = 'approved'";
    $sql_pending_app = "SELECT COUNT(*) FROM `event_application` WHERE `status` = 'pending'";

    $sql_event = "SELECT COUNT(*) FROM `events`";

    $sql_teams = "SELECT COUNT(*) FROM `teams` WHERE `status` = 'authenticated'";
    $sql_pending_teams = "SELECT COUNT(*) FROM `teams` WHERE `status` = 'pending'";
    
    $user_total = mysqli_fetch_array(mysqli_query($con, $sql_users));
    $user_pending_total = mysqli_fetch_array(mysqli_query($con, $sql_pending_users));
    $admin_total = mysqli_fetch_array(mysqli_query($con, $sql_admin));

    $app_total = mysqli_fetch_array(mysqli_query($con, $sql_app));
    $app_pending_total = mysqli_fetch_array(mysqli_query($con, $sql_pending_app));

    $event_total = mysqli_fetch_array(mysqli_query($con, $sql_event));

    $teams_total = mysqli_fetch_array(mysqli_query($con, $sql_teams));
    $teams_pending_total = mysqli_fetch_array(mysqli_query($con, $sql_pending_teams));

    //Data for charts -----------------------------------------------------------------------------------------------------------------------------------------------
    $first  = strtotime('first day this month');
    $months = array();

    for ($i = 0; $i < 6; $i++) {
        array_push($months, date('M', strtotime("-$i month", $first)));
    }
    
    //Total User Registrations
    $userRegTot = array();
    for ($ctr = 0; $ctr < 6; $ctr++) {
        $month_reg_tot = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) FROM `users`
                                WHERE YEAR(`created_at`) = YEAR(CURRENT_DATE - INTERVAL ".$ctr." MONTH)
                                AND MONTH(`created_at`) = MONTH(CURRENT_DATE - INTERVAL ".$ctr." MONTH)"));

        array_push($userRegTot, $month_reg_tot[0]);
    }

    $maxUserReg = max($userRegTot);

    //Total Events
    $eventTot = array();
    for ($ctr = 0; $ctr < 6; $ctr++) {
        $event_tot = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) FROM `events`
                                WHERE YEAR(`approved_at`) = YEAR(CURRENT_DATE - INTERVAL ".$ctr." MONTH)
                                AND MONTH(`approved_at`) = MONTH(CURRENT_DATE - INTERVAL ".$ctr." MONTH)"));

        array_push($eventTot, $event_tot[0]);
    }

    $maxEvent = max($eventTot);

    //Total Teams
    $teamTot = array();
    for ($ctr = 0; $ctr < 6; $ctr++) {
        $team_tot = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) FROM `teams`
                                WHERE YEAR(`created_at`) = YEAR(CURRENT_DATE - INTERVAL ".$ctr." MONTH)
                                AND MONTH(`created_at`) = MONTH(CURRENT_DATE - INTERVAL ".$ctr." MONTH)"));

        array_push($teamTot, $team_tot[0]);
    }

    $maxTeam = max($teamTot);
?>

    <!--
=========================================================
Material Dashboard - v2.1.2
=========================================================

Product Page: https://www.creative-tim.com/product/material-dashboard
Copyright 2020 Creative Tim (https://www.creative-tim.com)
Coded by Creative Tim

=========================================================
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
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
        <!--     Fonts and icons     -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
        <!-- CSS Files -->
        <link href="assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
        <!-- CSS Just for demo purpose, don't include it in your project -->
        <link href="assets/demo/demo.css" rel="stylesheet" />
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
                        <li class="nav-item active  ">
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
                        <li class="nav-item ">
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
                            <a class="navbar-brand" href="javascript:;">Dashboard</a>
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
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-warning card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">person</i>
                                        </div>
                                        <p class="card-category">Total Registered Users</p>
                                        <h3 class="card-title"><?php echo $user_total[0] + $user_pending_total[0]; ?></h3>
                                    </div>
                                    <div class="card-footer">
                                        <i class="material-icons text-success">person</i>
                                        <div>Authenticated Users: <b style="color: green;"><?php echo $teams_total[0]; ?></b></div>
                                    </div>
                                    <div class="card-footer">
                                        <i class="material-icons text-danger">person</i>
                                        <div>Users Pending Authentication: <b style="color: red;"><?php echo $teams_pending_total[0]; ?></b></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-success card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">insert_drive_file</i>
                                        </div>
                                        <p class="card-category">Total Event Applications</p>
                                        <h3 class="card-title"><?php echo $app_total[0] + $app_pending_total[0]; ?></h3>
                                    </div>
                                    <div class="card-footer">
                                        <i class="material-icons text-success">insert_drive_file</i>
                                        <div>Approved Applications: <b style="color: green;"><?php echo $teams_total[0]; ?></b></div>
                                    </div>
                                    <div class="card-footer">
                                        <i class="material-icons text-danger">insert_drive_file</i>
                                        <div>Applications Pending Approval: <b style="color: red;"><?php echo $teams_pending_total[0]; ?></b></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-info card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">emoji_events</i>
                                        </div>
                                        <p class="card-category">Total Events</p>
                                        <h3 class="card-title"><?php echo $event_total[0]; ?></h3>
                                    </div>
                                    <div class="card-footer">
                                        <i class="material-icons text-success">emoji_events</i>
                                        <div>Active Events: <b style="color: green;"><?php echo $teams_total[0]; ?></b></div>
                                    </div>
                                    <div class="card-footer">
                                        <i class="material-icons text-danger">emoji_events</i>
                                        <div>Inactive Events: <b style="color: red;"><?php echo $teams_pending_total[0]; ?></b></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-danger card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">people_alt</i>
                                        </div>
                                        <p class="card-category">Total Teams</p>
                                        <h3 class="card-title"><?php echo $teams_total[0] + $teams_pending_total[0]; ?></h3>
                                    </div>
                                    <div class="card-footer">
                                        <i class="material-icons text-success">people_alt</i>
                                        <div>Authenticated Teams: <b style="color: green;"><?php echo $teams_total[0]; ?></b></div>
                                    </div>
                                    <div class="card-footer">
                                        <i class="material-icons text-danger">people_alt</i>
                                        <div>Teams Pending Authentication: <b style="color: red;"><?php echo $teams_pending_total[0]; ?></b></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card card-chart">
                                    <div class="card-header card-header-success">
                                        <div class="ct-chart" id="totalUserChart"></div>
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">User Registrations</h4>
                                        <p class="card-category">
                                            Total User Registrations in the last 6 months</p>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">access_time</i> just updated
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-chart">
                                    <div class="card-header card-header-warning">
                                        <div class="ct-chart" id="totalEventChart"></div>
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">Total Events</h4>
                                        <p class="card-category">Total Events Added and Approved in the last 6 months</p>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">access_time</i> just updated
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-chart">
                                    <div class="card-header card-header-danger">
                                        <div class="ct-chart" id="totalTeamChart"></div>
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">Total Teams</h4>
                                        <p class="card-category">Total Teams Created in the last 6 months</p>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons">access_time</i> just updated
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <!--
                            <div class="col-lg-6 col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-tabs card-header-primary">
                                        <div class="nav-tabs-navigation">
                                            <div class="nav-tabs-wrapper">
                                                <span class="nav-tabs-title">Tasks:</span>
                                                <ul class="nav nav-tabs" data-tabs="tabs">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" href="#profile" data-toggle="tab">
                                                            <i class="material-icons">bug_report</i> Bugs
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#messages" data-toggle="tab">
                                                            <i class="material-icons">code</i> Website
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#settings" data-toggle="tab">
                                                            <i class="material-icons">cloud</i> Server
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="profile">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                        <input class="form-check-input" type="checkbox" value="" checked>
                                                                        <span class="form-check-sign">
                                                                            <span class="check"></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td>Sign contract for "What are conference organizers afraid of?"</td>
                                                            <td class="td-actions text-right">
                                                                <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                                                    <i class="material-icons">edit</i>
                                                                </button>
                                                                <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                                                    <i class="material-icons">close</i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                        <input class="form-check-input" type="checkbox" value="">
                                                                        <span class="form-check-sign">
                                                                            <span class="check"></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td>Lines From Great Russian Literature? Or E-mails From My Boss?</td>
                                                            <td class="td-actions text-right">
                                                                <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                                                    <i class="material-icons">edit</i>
                                                                </button>
                                                                <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                                                    <i class="material-icons">close</i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                        <input class="form-check-input" type="checkbox" value="">
                                                                        <span class="form-check-sign">
                                                                            <span class="check"></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
                                                            </td>
                                                            <td class="td-actions text-right">
                                                                <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                                                    <i class="material-icons">edit</i>
                                                                </button>
                                                                <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                                                    <i class="material-icons">close</i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                        <input class="form-check-input" type="checkbox" value="" checked>
                                                                        <span class="form-check-sign">
                                                                            <span class="check"></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td>Create 4 Invisible User Experiences you Never Knew About</td>
                                                            <td class="td-actions text-right">
                                                                <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                                                    <i class="material-icons">edit</i>
                                                                </button>
                                                                <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                                                    <i class="material-icons">close</i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane" id="messages">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                        <input class="form-check-input" type="checkbox" value="" checked>
                                                                        <span class="form-check-sign">
                                                                            <span class="check"></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
                                                            </td>
                                                            <td class="td-actions text-right">
                                                                <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                                                    <i class="material-icons">edit</i>
                                                                </button>
                                                                <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                                                    <i class="material-icons">close</i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                        <input class="form-check-input" type="checkbox" value="">
                                                                        <span class="form-check-sign">
                                                                            <span class="check"></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td>Sign contract for "What are conference organizers afraid of?"</td>
                                                            <td class="td-actions text-right">
                                                                <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                                                    <i class="material-icons">edit</i>
                                                                </button>
                                                                <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                                                    <i class="material-icons">close</i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane" id="settings">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                        <input class="form-check-input" type="checkbox" value="">
                                                                        <span class="form-check-sign">
                                                                            <span class="check"></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td>Lines From Great Russian Literature? Or E-mails From My Boss?</td>
                                                            <td class="td-actions text-right">
                                                                <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                                                    <i class="material-icons">edit</i>
                                                                </button>
                                                                <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                                                    <i class="material-icons">close</i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                        <input class="form-check-input" type="checkbox" value="" checked>
                                                                        <span class="form-check-sign">
                                                                            <span class="check"></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td>Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit
                                                            </td>
                                                            <td class="td-actions text-right">
                                                                <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                                                    <i class="material-icons">edit</i>
                                                                </button>
                                                                <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                                                    <i class="material-icons">close</i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                        <input class="form-check-input" type="checkbox" value="" checked>
                                                                        <span class="form-check-sign">
                                                                            <span class="check"></span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td>Sign contract for "What are conference organizers afraid of?"</td>
                                                            <td class="td-actions text-right">
                                                                <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                                                                    <i class="material-icons">edit</i>
                                                                </button>
                                                                <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                                                                    <i class="material-icons">close</i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            !-->
                            <div class="col-lg-12 col-md-12">
                                <div class="card">
                                    <div class="card-header card-header-info">
                                        <h4 class="card-title">Site Admins</h4>
                                        <p class="card-category">Current details of all Site Admins. Total Site Administrators: <?php echo $admin_total[0]; ?></p>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table class="table table-hover">
                                            <thead class="text-info">
                                                <th>No.</th>
                                                <th>Name</th>
                                                <th>User ID</th>
                                                <th>Mobile Number</th>
                                                <th>Email Address</th>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <?php $ctr = 1;
                                                while($row = mysqli_fetch_array($admin_list)):;?>
                                                <tr>
                                                <td><span><?php echo $ctr;?></span></td>
                                                <td><span><?php echo $row[0];?></span></td>
                                                <td><span><?php echo $row[1];?></span></td>
                                                <td><span><?php echo $row[2];?></span></td>
                                                <td><span><?php echo $row[3];?></span></td>
                                                </tr>
                                                <?php $ctr++;
                                                endwhile;?>
                                            </tr>
                                            </tbody>
                                        </table>
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
        <script src="assets/js/material-dashboard.js" type="text/javascript"></script>
        <!-- Material Dashboard DEMO methods, don't include it in your project! -->
        <script src="assets/demo/demo.js"></script>
        <script>
            $(document).ready(function() {
                $().ready(function() {
                    $sidebar = $('.sidebar');

                    $sidebar_img_container = $sidebar.find('.sidebar-background');

                    $full_page = $('.full-page');

                    $sidebar_responsive = $('body > .navbar-collapse');

                    window_width = $(window).width();

                    fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

                    if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
                        if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
                            $('.fixed-plugin .dropdown').addClass('open');
                        }

                    }

                    $('.fixed-plugin a').click(function(event) {
                        // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
                        if ($(this).hasClass('switch-trigger')) {
                            if (event.stopPropagation) {
                                event.stopPropagation();
                            } else if (window.event) {
                                window.event.cancelBubble = true;
                            }
                        }
                    });

                    $('.fixed-plugin .active-color span').click(function() {
                        $full_page_background = $('.full-page-background');

                        $(this).siblings().removeClass('active');
                        $(this).addClass('active');

                        var new_color = $(this).data('color');

                        if ($sidebar.length != 0) {
                            $sidebar.attr('data-color', new_color);
                        }

                        if ($full_page.length != 0) {
                            $full_page.attr('filter-color', new_color);
                        }

                        if ($sidebar_responsive.length != 0) {
                            $sidebar_responsive.attr('data-color', new_color);
                        }
                    });

                    $('.fixed-plugin .background-color .badge').click(function() {
                        $(this).siblings().removeClass('active');
                        $(this).addClass('active');

                        var new_color = $(this).data('background-color');

                        if ($sidebar.length != 0) {
                            $sidebar.attr('data-background-color', new_color);
                        }
                    });

                    $('.fixed-plugin .img-holder').click(function() {
                        $full_page_background = $('.full-page-background');

                        $(this).parent('li').siblings().removeClass('active');
                        $(this).parent('li').addClass('active');


                        var new_image = $(this).find("img").attr('src');

                        if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                            $sidebar_img_container.fadeOut('fast', function() {
                                $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                                $sidebar_img_container.fadeIn('fast');
                            });
                        }

                        if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
                            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                            $full_page_background.fadeOut('fast', function() {
                                $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                                $full_page_background.fadeIn('fast');
                            });
                        }

                        if ($('.switch-sidebar-image input:checked').length == 0) {
                            var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                        }

                        if ($sidebar_responsive.length != 0) {
                            $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
                        }
                    });

                    $('.switch-sidebar-image input').change(function() {
                        $full_page_background = $('.full-page-background');

                        $input = $(this);

                        if ($input.is(':checked')) {
                            if ($sidebar_img_container.length != 0) {
                                $sidebar_img_container.fadeIn('fast');
                                $sidebar.attr('data-image', '#');
                            }

                            if ($full_page_background.length != 0) {
                                $full_page_background.fadeIn('fast');
                                $full_page.attr('data-image', '#');
                            }

                            background_image = true;
                        } else {
                            if ($sidebar_img_container.length != 0) {
                                $sidebar.removeAttr('data-image');
                                $sidebar_img_container.fadeOut('fast');
                            }

                            if ($full_page_background.length != 0) {
                                $full_page.removeAttr('data-image', '#');
                                $full_page_background.fadeOut('fast');
                            }

                            background_image = false;
                        }
                    });

                    $('.switch-sidebar-mini input').change(function() {
                        $body = $('body');

                        $input = $(this);

                        if (md.misc.sidebar_mini_active == true) {
                            $('body').removeClass('sidebar-mini');
                            md.misc.sidebar_mini_active = false;

                            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

                        } else {

                            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

                            setTimeout(function() {
                                $('body').addClass('sidebar-mini');

                                md.misc.sidebar_mini_active = true;
                            }, 300);
                        }

                        // we simulate the window Resize so the charts will get updated in realtime.
                        var simulateWindowResize = setInterval(function() {
                            window.dispatchEvent(new Event('resize'));
                        }, 180);

                        // we stop the simulation of Window Resize after the animations are completed
                        setTimeout(function() {
                            clearInterval(simulateWindowResize);
                        }, 1000);

                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                var months = <?php echo json_encode($months); ?>;
                var userArray = <?php echo json_encode($userRegTot); ?>;
                var eventArray = <?php echo json_encode($eventTot); ?>;
                var teamArray = <?php echo json_encode($teamTot); ?>;

                var maxUser = <?php echo $maxUserReg; ?>;
                var maxEvent = <?php echo $maxEvent; ?>;
                var maxTeam = <?php echo $maxTeam; ?>;

                if ($('#totalUserChart').length != 0 || $('#totalTeamChart').length != 0 || $('#totalEventChart').length != 0) {
                /* ----------==========     Total User Registrations Chart initialization    ==========---------- */

                dataTotalUserChart = {
                    labels: [months[5], months[4], months[3], months[2], months[1], months[0]],
                    series: [
                        [userArray[5], userArray[4], userArray[3], userArray[2], userArray[1], userArray[0]]
                    ]
                };

                optionsTotalUserChart = {
                    lineSmooth: Chartist.Interpolation.cardinal({
                        tension: 0
                    }),
                    low: 0,
                    high: maxUser + 10, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
                    chartPadding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0
                    },
                }

                var totalUserChart = new Chartist.Line('#totalUserChart', dataTotalUserChart, optionsTotalUserChart);

                md.startAnimationForLineChart(totalUserChart);



                /* ----------==========     Total Teams Chart initialization    ==========---------- */

                dataTotalTeamChart = {
                    labels: [months[5], months[4], months[3], months[2], months[1], months[0]],
                    series: [
                        [teamArray[5], teamArray[4], teamArray[3], teamArray[2], teamArray[1], teamArray[0]]
                    ]
                };

                optionsTotalTeamChart = {
                    lineSmooth: Chartist.Interpolation.cardinal({
                        tension: 0
                    }),
                    low: 0,
                    high: maxTeam + 5, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
                    chartPadding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0
                    }
                }

                var totalTeamChart = new Chartist.Line('#totalTeamChart', dataTotalTeamChart, optionsTotalTeamChart);

                // start animation for the Completed Tasks Chart - Line Chart
                md.startAnimationForLineChart(totalTeamChart);


                /* ----------==========     Total Events Chart initialization    ==========---------- */

                var dataTotalEventChart = {
                    labels: [months[5], months[4], months[3], months[2], months[1], months[0]],
                    series: [
                        [eventArray[5], eventArray[4], eventArray[3], eventArray[2], eventArray[1], eventArray[0]]
                    ]
                };
                var optionsTotalEventChart = {
                    axisX: {
                        showGrid: false
                    },
                    low: 0,
                    high: maxEvent + 10,
                    chartPadding: {
                        top: 0,
                        right: 5,
                        bottom: 0,
                        left: 0
                    }
                };
                var responsiveOptions = [
                    ['screen and (max-width: 640px)', {
                        seriesBarDistance: 5,
                        axisX: {
                            labelInterpolationFnc: function(value) {
                                return value[0];
                            }
                        }
                    }]
                ];
                var totalEventChart = Chartist.Bar('#totalEventChart', dataTotalEventChart, optionsTotalEventChart, responsiveOptions);

                //start animation for the Emails Subscription Chart
                md.startAnimationForBarChart(totalEventChart);
                }

            });
        </script>
    </body>

    </html>