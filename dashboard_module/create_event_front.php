<?php
  include '../public/DBconnect.php';
  session_start();

  //connection to database
  $con = DatabaseConn();
  $userOptions = '';

  $curUser = $_SESSION['Curr_user'];

  $application_data = mysqli_query($con, "SELECT app_name, app_description, game_id, team_count, start_datetime, end_datetime, venue, city, state, organiser FROM event_application WHERE app_id = '1'");
  $data = mysqli_fetch_array($application_data);

  //Assign variables
  $app_name = $data['app_name'];
  $app_desc = $data['app_description'];
  $game = $data['game_id'];
  $max_reg_cnt = $data['team_count'];
  $startDate = $data['start_datetime'];
  $endDate = $data['end_datetime'];
  $venue = $data['venue'];
  $city = $data['city'];
  $state = strtoupper($data['state']);
  $org = $data['organiser'];

  //Generating options for the event admins and event staff selects
  $users = mysqli_query($con,"SELECT id, full_name, user_id FROM users WHERE status='authenticated' AND is_admin = '0'");
  while($row = mysqli_fetch_array($users)) {
    $userOptions .= '<option value="'.$row['id'].'">'.$row['full_name'].' ('.$row['user_id'].')</option>';
  }

  //Help message initialization
  $help_msg = "The Event Admins and Event Staff fields are used to assign event administrators and staff who can manage and view information on event participants.<br><br>You must assign at least one event admin to proceed with event creation. Both event admins and staff can be added/changed after the event has been created.<br><br><b>Note</b>: All site admins automatically have admin permissions for every event.";
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
            <a class="nav-link" href="./dashboard.html">
              <i class="material-icons">dashboard</i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item active ">
            <a class="nav-link" href="./user.html">
              <i class="material-icons">person</i>
              <p>User Profile</p>
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
            <a class="navbar-brand" href="javascript:;">Event Form</a>
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
                  <i class="material-icons">search</i>
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
            <div class="col-md-11">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title" style="display: inline-block;">Create New Event</h4>
                  <p class="card-category" >Please enter event details below</p>
                </div>
                <br>
                <div class="card-body">
                  <form id="createEventAppForm">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Event Name*</label>
                          <input type="text" class="form-control" name="ev_name" value="<?php echo $app_name; ?>" required>
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Event Description*</label>
                          <textarea rows=1 type="text" class="form-control autoExpand" name="ev_desc" required><?php echo $app_desc; ?></textarea>
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-9">
                        <div class="form-group">
                          <label class="bmd-label-floating">Organisers* (e.g. Organiser 1,Organiser2,...)</label>
                          <input type="text" class="form-control" name="org" value="<?php echo $org; ?>" required>
                        </div>
                      </div>
                      <div class="col-md-3">
                        Event Type*
                        <select class="select2 form-control" name="ev_type" required>
                            <option value="TOURNAMENT">Tournament</option>
                        </select>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Game</label>
                          <input type="text" class="form-control" name="game" value="<?php echo $game; ?>">
                        </div>
                      </div>
                      <div class="col-md-3">
                        Registration Type*
                        <select class="select2 form-control" name="reg_type" required>
                            <option value="TEAM">Teams</option>
                            <option value="INDIV">Individual</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Max Participants* (No. of Teams <b>OR</b> Individual Participants)</label>
                          <input type="number" min="0" class="form-control" name="reg_max" value="<?php echo $max_reg_cnt; ?>">
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Venue*</label>
                          <input type="text" class="form-control" name="venue" value="<?php echo $venue; ?>" required>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">City*</label>
                          <input type="text" class="form-control" name="city" value="<?php echo $city; ?>" required>
                        </div>
                      </div>
                      <div class="col-md-4">
                        State*
                        <select class="select2 form-control" name="state" required>
                            <option value="PERLIS" <?=$state == 'PERLIS' ? ' selected="selected"' : '';?>>Perlis</option>
                            <option value="PERAK" <?=$state == 'PERAK' ? ' selected="selected"' : '';?>>Perak</option>
                            <option value="KEDAH" <?=$state == 'KEDAH' ? ' selected="selected"' : '';?>>Kedah</option>
                            <option value="PENANG" <?=$state == 'PENANG' ? ' selected="selected"' : '';?>>Penang</option>
                            <option value="KELANTAN" <?=$state == 'KELANTAN' ? ' selected="selected"' : '';?>>Kelantan</option>
                            <option value="TERENGGANU" <?=$state == 'TERENGGANU' ? ' selected="selected"' : '';?>>Terengganu</option>
                            <option value="PAHANG" <?=$state == 'PAHANG' ? ' selected="selected"' : '';?>>Pahang</option>
                            <option value="SELANGOR" <?=$state == 'SELANGOR' ? ' selected="selected"' : '';?>>Selangor</option>
                            <option value="MELAKA" <?=$state == 'MELAKA' ? ' selected="selected"' : '';?>>Melaka</option>
                            <option value="NEGERI SEMBILAN" <?=$state == 'NEGERI SEMBILAN' ? ' selected="selected"' : '';?>>Negeri Sembilan</option>
                            <option value="JOHOR" <?=$state == 'JOHOR' ? ' selected="selected"' : '';?>>Johor</option>
                            <option value="SABAH" <?=$state == 'SABAH' ? ' selected="selected"' : '';?>>Sabah</option>
                            <option value="SARAWAK" <?=$state == 'SARAWAK' ? ' selected="selected"' : '';?>>Sarawak</option>
                            <option value="WILAYAH PERSEKUTUAN" <?=$state == 'WILAYAH PERSEKUTUAN' ? ' selected="selected"' : '';?>>Wilayah Persekutuan</option>
                        </select>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Start Time*</label>
                          <input placeholder="" class="form-control" type="text" onfocus="(this.type='datetime-local')" onblur="dateInputBehavior(this)" name="startDate" value="<?php echo $startDate; ?>" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">End Time*</label>
                          <input placeholder="" class="form-control" type="text" onfocus="(this.type='datetime-local')" onblur="dateInputBehavior(this)" name="endDate" value="<?php echo $endDate; ?>" required>
                        </div>
                      </div>
                    </div>
                    <br><br><br>
                    <h4 style="display: inline-block;">Event Personnel Assignment</h4>
                    <div style="display: inline-block;">
                      <button class="icon-button" type="button" onclick="md.showNotification('top','right', '<?php echo $help_msg; ?>')"><i class="material-icons" style="font-size:20px;">help</i></button>
                    </div>
                    <br><br>
                    <div class="row">
                      <div class="col-md-6">
                        <h6>Event Admins*</h6>
                        <select class="select2 select2-ev-admin form-control" name="ev_admins" multiple="multiple" required>
                          <?php echo $userOptions; ?>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <h6>Event Staff</h6>
                        <select class="select2 select2-ev-staff form-control" name="ev_staff" multiple="multiple" required>
                          <?php echo $userOptions; ?>
                        </select>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <b>Event Admins</b> are able to:
                        <!-- TODO: Add full descriptions for both admins and staff -->
                      </div>
                      <div class="col-md-6">
                        <b>Event Staff</b> are able to:
                      </div>
                    </div>
                    <br><br>
                    <span style="color: red;">* Fields are compulsory</span>
                    <button style="inline-block" type="submit" class="btn btn-primary pull-right" name="submitBtn">Submit</button>
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
  <script src="assets/js/material-dashboard.js" type="text/javascript"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script src="assets/demo/demo.js"></script>
  <script>
  $(document).ready(function() {
    $('.select2').select2({
      minimumResultsForSearch: 20
    });

    $('.select2-ev-admin, .select2-ev-staff').select2({
      placeholder: 'Search for users using their name or user ID'
    });
  });

  $(document).on('submit', '#createEventAppForm', function() {
    // do not refresh form on submit so that notifications can be shown
    return false;
  });

  $(document) //Code to expand textarea based on contents
    .one('focus.autoExpand', 'textarea.autoExpand', function(){
        var savedValue = this.value;
        this.value = '';
        this.baseScrollHeight = this.scrollHeight;
        this.value = savedValue;
    })
    .on('input.autoExpand', 'textarea.autoExpand', function(){
        var minRows = this.getAttribute('data-min-rows')|0, rows;
        this.rows = minRows;
        rows = Math.ceil((this.scrollHeight - this.baseScrollHeight) / 16);
        this.rows = minRows + rows;
  });

  $(":button[name='submitBtn']").click(function(){
    var app_name = $("input[name='app_name']").val();
    var app_desc = $("textarea[name='app_desc']").val();
    var org = $("input[name='org']").val();
    var game = $("input[name='game']").val();
    var teams = $("input[name='teams']").val()
    var venue = $("input[name='venue']").val();
    var city = $("input[name='city']").val();
    var state = $("select[name='state']").val();
    var startDate = $("input[name='startDate']").val();
    var endDate = $("input[name='endDate']").val();
    var contact_method = $("select[name='contact_method']").val();
    var phone_select = $("select[name='phone_select']").val();
    var contact_no = $("input[name='contact_no']").val();
    var email_select = $("select[name='email_select']").val();
    var email_address = $("input[name='email_address']").val();
    var created_by = '<?php echo $curUser; ?>';

    if (app_name != "" && app_desc != "" && org != "" && venue != "" &&
        city != "" && state != "" && startDate != "" && endDate != "" &&
        contact_method != "" && phone_select != "" && contact_no != "" &&
        email_select != "" && email_address != "") {
            
        $.ajax({
            url: 'create_event_application_back.php',
            type: 'POST',
            data: {app_name: app_name, app_desc: app_desc, org: org,
                    game: game, teams: teams, venue: venue,
                    city: city, state: state, startDate: startDate,
                    endDate: endDate, contact_method: contact_method, phone_select: phone_select,
                    contact_no: contact_no, email_select: email_select, email_address: email_address,
                    created_by: created_by},
            success: function(res) {
                var data = JSON.parse(res);

                if (data['statusCode'] == 1) { //'1' is set as success code ('0' for fail)
                    $.notify({
                        message: data['msg']
                    }, {
                        type: 'success',
                        allow_dismiss: true
                    });
                } else {
                    $.notify({
                        message: data['msg']
                    }, {
                        type: 'danger',
                        allow_dismiss: true
                    });
                }
                
                if (data['statusCode'] == 1) { //Only reset the form if success code is returned
                  $('#createEventAppForm').trigger('reset'); //Empty all the form fields
                  $('[name="startDate"]').prop('type', 'text');
                  $('[name="endDate"]').prop('type', 'text'); //Remove 'dd/mm/yyyy' placeholder from start/end date
                }
            },
            error: function(res) {
                $.notify("An error has ocurred! Please try again later");
            }
            });
      }
  });

  function dateInputBehavior(e) {
    if (e.value == "" || e.value == null) {
        e.type = "text"; //Change input back to text to remove 'dd/mm/yyyy' placeholder
    } else {
        e.type = "datetime-local";
    }
  }
  </script>
</body>

</html>