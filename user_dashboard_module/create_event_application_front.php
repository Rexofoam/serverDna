<?php
  include '../public/DBconnect.php';
  session_start();

  //connection to database
  $con = DatabaseConn();

  $curUser = $_SESSION['Curr_user'];

  $sql = mysqli_query($con,"SELECT mobile_number, email FROM users WHERE id = '$curUser'");
  $result = mysqli_fetch_array($sql);

  //Assign variables
  $userNo = $result['mobile_number'];
  $userEmail = $result['email'];

  //Help message initialization
  $help_msg = "Submitting this form will send an event application with the entered details to our representative(s) for review.<br><br>Please ensure you have included your contact details so that the creation of this event may be discussed/approved/finalized";
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
            <a class="navbar-brand" href="javascript:;">Event Application</a>
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
                  <h4 class="card-title" style="display: inline-block;">Create New Event Application</h4>
                  <div style="display: inline-block;">
                      <button class="icon-button" onclick="md.showNotification('top','right', '<?php echo $help_msg; ?>')"><i class="material-icons md-light" style="font-size:20px;">help</i></button>
                  </div>
                  <p class="card-category" >Please enter your event's details below</p>
                </div>
                <br>
                <div class="card-body">
                  <form id="createEventAppForm">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Event Name*</label>
                          <input type="text" class="form-control" name="app_name" required>
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating">Event Description*</label>
                          <textarea rows=1 type="text" class="form-control autoExpand" name="app_desc" required></textarea>
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Main Organiser*</label>
                          <input type="text" class="form-control" name="org" required>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Game</label>
                          <input type="text" class="form-control" name="game">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label class="bmd-label-floating">Teams/Players</label>
                          <input type="number" min="0" class="form-control" name="teams">
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">Venue*</label>
                          <input type="text" class="form-control" name="venue" required>
                        </div>
                      </div>
                      <div class="col-md-4">
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
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">Start Date*</label>
                          <input placeholder="" class="form-control" type="text" onfocus="(this.type='date')" onblur="dateInputBehavior(this)" name="startDate" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">End Date*</label>
                          <input placeholder="" class="form-control" type="text" onfocus="(this.type='date')" onblur="dateInputBehavior(this)" name="endDate" required>
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        Preferred Method of Contact*
                        <select class="select2 form-control" name="contact_method" required>
                            <option value="CALL">Phone Call</option>
                            <option value="WHATSAPP">Whatsapp</option>
                            <option value="EMAIL">E-Mail</option>
                        </select>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        Phone Number*
                        <select class="select2 form-control" name="phone_select" required>
                            <option value="0">Use my current number</option>
                            <option value="1">Enter a different number</option>
                            <option value="-1">Do not use phone</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label name="contact_no_label" class="bmd-label-floating">If different number, please state*</label>
                          <input type="tel" class="form-control" name="contact_no" pattern="01[0-9]{8,9}" required>
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        Email Address*
                        <select class="select2 form-control" name="email_select" required>
                            <option value="0">Use my current email</option>
                            <option value="1">Enter a different email</option>
                            <option value="-1">Do not use email</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label name="email_label" class="bmd-label-floating">If different email, please state*</label>
                          <input type="email" class="form-control" name="email_address" required>
                        </div>
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
      minimumResultsForSearch: -1
    });

    // Default contact number and contact email states
    $('select[name="phone_select"]').val('0').trigger('change');
    $('select[name="email_select"]').val('0').trigger('change');
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

                  // Reset contact no and email address states
                  $('select[name="phone_select"]').val('0').trigger('change');
                  $('select[name="email_select"]').val('0').trigger('change');
                }
            },
            error: function(res) {
                $.notify("An error has ocurred! Please try again later");
            }
            });
    }
});

$("select[name='phone_select']").on('change', function() {
  /* Function to fill in phone number based on user selection
   * 0  - Use current user's account phone number and disable contact_no input
   * 1  - Use new phone number, enable and make contact_no input ""
   * -1 - Don't input phone number, disable and make contact_no input "-"
   */
    var user_phone = '<?php echo $userNo; ?>';

    if ($("select[name='phone_select']").val() == '0') {
      $("input[name='contact_no']").show().val(user_phone).prop("disabled", true).prop("required", true); //TODO: Replace this with user's phone no
      $("label[name='contact_no_label']").hide();
    } else if ($("select[name='phone_select']").val() == '1') {
      $("input[name='contact_no']").show().val('').prop("disabled", false).prop("required", true); 
      $("label[name='contact_no_label']").show();
    } else {
      $("input[name='contact_no']").hide().val('-').prop("disabled", true).prop("required", false); 
      $("label[name='contact_no_label']").hide();
    }
});

$("select[name='email_select']").on('change', function() {
  /* Function to fill in email address based on user selection
   * 0  - Use current user's account phone number and disable contact_no input
   * 1  - Use new phone number, enable and make contact_no input ""
   * -1 - Don't input phone number, disable and make contact_no input "-"
   */
    var user_email = '<?php echo $userEmail; ?>';

    if ($("select[name='email_select']").val() == '0') {
      $("input[name='email_address']").show().val(user_email).prop("disabled", true).prop("required", true); //TODO: Replace this with user's phone no
      $("label[name='email_label']").hide();
    } else if ($("select[name='email_select']").val() == '1') {
      $("input[name='email_address']").show().val('').prop("disabled", false).prop("required", true); 
      $("label[name='email_label']").show();
    } else {
      $("input[name='email_address']").hide().val('-').prop("disabled", true).prop("required", false); 
      $("label[name='email_label']").hide();
    }
});

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