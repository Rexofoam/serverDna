<!DOCTYPE html>
<html lang="en">
<?php 
  include '../public/DBconnect.php';

  session_start();
  $con = DatabaseConn();

  if (isset($_SESSION['Curr_user'])) {
    // do nothing
  } else {
    header("Location: ../login_module/index.php");
  }

  $userID = $_SESSION['Curr_user'];

  // for notification header
  $sql_notification = "SELECT `notification`.`id`, `notification`.`title`, `notification`.`description`, `notification`.`type`, `users`.`full_name` FROM `notification` JOIN `users` ON `users`.`id` = `notification`.`to_user_id`  WHERE `notification`.`read_at` is null AND `notification`.`to_user_id` = '$userID' AND `notification`.`delete_at` is NULL ORDER BY id desc LIMIT 5";
  $notifications = mysqli_query($con, $sql_notification);
  $notification_count = 0; // default display in no notification

  // End of notification module
  
  $sql_teams = "SELECT t.`team_id`, t.`team_name`, u.`full_name`
                FROM `teams` t JOIN `user_teams` ut ON t.`team_id` = ut.`team_id` JOIN `users` u ON ut.`user_id` = u.`id`
                WHERE ut.`user_id` = '$userID'";

  if (isset($_GET['query'])) { //If user has entered search query, page has refreshed to generate new results
    $query = strtoupper($_GET['query']);
    $sql_teams .= " AND (UPPER(t.`team_id`) LIKE '%".$query."%')"; //Search by team name
  }

  $teams = mysqli_query($con, $sql_teams);

  if (isset($_SESSION['update_response']) ) {
      $response = $_SESSION['update_response'];
      unset($_SESSION['update_response']);
  } else {
      $response = null;
  }
?>
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

<body class="" onload="fetchUpdateResponse()">
  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="assets/img/sidebar-1.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo"><a href="http://www.creative-tim.com" class="simple-text logo-normal">
          ServerDNA
      </a></div>
      <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="nav-item ">
                        <a class="nav-link" href="./dashboard.php">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./profile_details.php">
                            <i class="material-icons">person</i>
                            <p>My Profile</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="./create_event_application_front.php">
                            <i class="material-icons">insert_drive_file</i>
                            <p>New Event Application</p>
                        </a>
                    </li>
                    <li class="nav-item active  ">
                        <a class="nav-link" href="./team_list.php">
                            <i class="material-icons">people_alt</i>
                            <p>My Teams</p>
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
            <form class="navbar-form" method="GET" action="team_list.php">
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" name="query" placeholder="Search teams...">
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
                                    <span class="notification"></span>
                                    <p class="d-lg-none d-md-block">
                                        Some Actions
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <?php if ($notifications) { ?>
                                        <?php while($row1 = mysqli_fetch_array($notifications)):;?>
                                        <a class="dropdown-item" href='notification.php?notification=<?php echo $row1[0];?>'><?php echo $row1[1]; $notification_count ++;?></a>
                                        <?php endwhile;?>
                                    <?php } if($notification_count == 0) { echo "  No notification.";} ?>
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
                                    <a class="dropdown-item" href="profile_details.php">Profile</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="../login_module/logout.php">Log out</a>
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
          <div class="col-md-6">
            <button type="button" class="btn btn-primary pull-left" onclick="clearSearch()" id="clear_search">Clear Search Results</button>
          </div>
          <div class="col-md-6">
            <button type="button" class="btn btn-primary pull-right" onclick="goCreatePage()" name="newTeamBtn">Create New Team</button>
          </div>
        </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card card-plain">
                <div class="card-header card-header-primary">
                  <h4 class="card-title mt-0"> My Teams </h4>
                  <p class="card-category" id="subtitle">All the teams in which you are a member are displayed here</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <!-- PHP list of event applications -->
                    <table class="table table-hover">
                      <thead class="">
                        <th>Team Name</th>
                        <th>Created by</th>
                        <th>Action</th>
                      </thead>
                      <tbody>
                        <?php if ($teams) { ?>
                        <?php while($row1 = mysqli_fetch_array($teams)):;?>
                        <tr>
                          <td><span><?php echo $row1[1];?></span></td>
                          <td><span><?php echo $row1[2];?></span></td>
                          <td><button  class ="btn-primary" style="border-color: transparent;" onclick="view_team(<?php echo $row1[0];?>)">View</button>
                        </tr>
                        <?php endwhile;?>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
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
  <script src="assets/js/material-dashboard.js?v=2.1.2" type="text/javascript"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script src="assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      var query = '<?php if (isset($_GET['query'])) echo $_GET['query'] ?>'; //If screen is displaying a search query
      
      if (query != '') {
        $('#subtitle').text("Displaying search results for query: \""+query+"\""); //Change subtitle to show query
        $('#clear_search').show(); //Show the 'clear search results' button
      } else {
        $('#clear_search').hide();
      }
    });

    function clearSearch() {
      //refresh page without parameters
      window.location.href = "team_list.php";
    }

    function goCreatePage() {
      //redirect to new team page
      window.location.href = "team_create_front.php";
    }

    function view_team(id) {
      var view_url = "team_details.php"

      // redirect to edit page
      window.location.href = view_url + "?id=" + id;
    }
  </script>
  <script type="text/javascript">
        function fetchUpdateResponse() {
            var response = "<?php echo $response; ?>";
            if(response == null || response == "") {

            } else {
                if(response == "success") {
                    Swal.fire({title: 'Success!', html: "Accepted team invitation !", type: 'success'});
                } else {
                    Swal.fire({title: 'Success!', html: response, type: 'success'});
                }
            }


        }
    </script>

</body>

</html>