<!DOCTYPE html>
<html lang="en">
<?php 
  include '../public/DBconnect.php';

  session_start();
  $con = DatabaseConn();
  $game_id = isset($_GET['id']) ? $_GET['id'] : '';

  //Default form details
  $formTitle = 'Game Registration';
  $formSubTitle = 'Register games to the database so that events based around them can be created';
  $formBtnText = 'Submit';
  $game_name = '';
  $game_platforms = '';
  $game_genres = '';
  $createOrEdit = 0; //Flag to select INSERT or UPDATE operation (0 - create/insert, 1 - update)

  //If the user clicks edit on a game record, page refreshes with game details alrdy in the form
  if ($game_id != '') {
    $formTitle = 'Edit Game Details';
    $formSubTitle = 'Update a registered game\'s name, platforms or genres';
    $formBtnText = 'Update';

    $sql = "SELECT `game_name`,`platforms`,`genres` FROM `games` WHERE `game_id` = '$game_id'";
    $game_details = mysqli_fetch_array(mysqli_query($con, $sql));

    $game_name = $game_details['game_name'];
    $game_platforms = $game_details['platforms'];
    $game_genres = $game_details['genres'];

    $createOrEdit = 1;
  }

  $curUser = $_SESSION['Curr_user'];

  $sql_games = "SELECT `game_name`,`platforms`,`genres`, `game_id` FROM `games`";
  $games = mysqli_query($con, $sql_games);
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

  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
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
          <li class="nav-item ">
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
            <li class="nav-item active">
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
            <a class="navbar-brand" href="javascript:;">Games</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
          <!-- Search feature for games list isnt needed
            <form class="navbar-form">
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <button type="submit" class="btn btn-white btn-round btn-just-icon">
                  <i class="material-icons">search</i>
                  <div class="ripple-container"></div>
                </button>
              </div>
            </form>
          -->
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
                    <h4 class="card-title" style="display: inline-block;"><?php echo $formTitle;?></h4>
                    <p class="card-category" ><?php echo $formSubTitle;?></p>
                  </div>
                  <br>
                  <div class="card-body">
                    <form id="createGameForm">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label class="bmd-label-floating">Game Name*</label>
                            <input type="text" class="form-control" name="game_name" value='<?php echo $game_name;?>' required>
                          </div>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-md-6">
                          <h6>Platform(s)*</h6>
                          <select class="select2 select2-game-plat form-control" name="game_plat" multiple="multiple" required>
                            <option value="PC" <?=strpos($game_platforms, "PC") !== false ? ' selected="selected"' : '';?>>PC</option>
                            <option value="CONSOLE" <?=strpos($game_platforms, "CONSOLE") !== false ? ' selected="selected"' : '';?>>Console</option>
                            <option value="MOBILE" <?=strpos($game_platforms, "MOBILE") !== false ? ' selected="selected"' : '';?>>Mobile</option>
                            <option value="OTHER" <?=strpos($game_platforms, "OTHER") !== false ? ' selected="selected"' : '';?>>Other</option>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <h6>Genre(s)*</h6>
                          <select class="select2 select2-game-genre form-control" name="game_genre" multiple="multiple" required>
                            <option value="FPS" <?=strpos($game_genres, "FPS") !== false ? ' selected="selected"' : '';?>>FPS</option>
                            <option value="MOBA" <?=strpos($game_genres, "MOBA") !== false ? ' selected="selected"' : '';?>>MOBA</option>
                            <option value="ROYALE" <?=strpos($game_genres, "ROYALE") !== false ? ' selected="selected"' : '';?>>Battle Royale</option>
                            <option value="STRATEGY" <?=strpos($game_genres, "STRATEGY") !== false ? ' selected="selected"' : '';?>>Strategy</option>
                            <option value="ACTION" <?=strpos($game_genres, "ACTION") !== false ? ' selected="selected"' : '';?>>Action</option>
                            <option value="FIGHT" <?=strpos($game_genres, "FIGHT") !== false ? ' selected="selected"' : '';?>>Fighting</option>
                            <option value="SPORT" <?=strpos($game_genres, "SPORT") !== false ? ' selected="selected"' : '';?>>Sports</option>
                            <option value="RACE" <?=strpos($game_genres, "RACE") !== false ? ' selected="selected"' : '';?>>Racing</option>
                            <option value="PUZZLE" <?=strpos($game_genres, "PUZZLE") !== false ? ' selected="selected"' : '';?>>Puzzle</option>
                            <option value="OTHER" <?=strpos($game_genres, "OTHER") !== false ? ' selected="selected"' : '';?>>Other</option>
                          </select>
                        </div>
                      </div>
                      <br><br>
                      <span style="color: red;">* Fields are compulsory</span>
                      <button style="inline-block" type="submit" class="btn btn-primary pull-right" name="submitBtn"><?php echo $formBtnText;?></button>
                      <div class="clearfix"></div>
                    </form>
                  </div>
                </div>
              </div>
            <div class="col-md-12">
              <div class="card card-plain">
                <div class="card-header card-header-primary">
                  <h4 class="card-title mt-0"> Games List </h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <!-- PHP list of event applications -->
                    <table class="table table-hover" style="table-layout: fixed;">
                      <thead class="">
                        <th>Game</th>
                        <th>Platform(s)</th>
                        <th>Genre</th>
                        <th>Action</th>
                      </thead>
                      <tbody>
                        <?php if ($games) { ?>
                        <?php while($row = mysqli_fetch_array($games)):;?>
                        <tr>
                          <td><span><?php echo $row[0];?></span></td>
                          <td style="word-wrap: break-word"><span><?php echo str_replace(',', '/', $row[1]);?></span></td>
                          <td style="word-wrap: break-word"><span><?php echo str_replace(',', '/', $row[2]);?></span></td>
                          <td><button  class ="btn-primary" style="border-color: transparent;" onclick="edit_game('<?php echo $row[3];?>')">Edit</button>
                          <button  class ="btn-primary" style="border-color: transparent;" onclick="delete_game('<?php echo $row[3];?>', '<?php echo $row[0];?>')">Delete</button>
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
  <!--Select2 JS -->
  <script src="vendor/select2/select2.min.js" type="text/javascript"></script>
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
      $('.select2').select2();

      $('.select2-game-plat').select2({
        placeholder: 'Select all the platforms the game is available on'
      });

      $('.select2-game-genre').select2({
        placeholder: 'Select all the genres the game falls under'
      });
    });

    $(document).on('submit', '#createGameForm', function() {
      // do not refresh form on submit so that notifications can be shown
      return false;
    });

    $(":button[name='submitBtn']").click(function(){
    var game_id = '<?php echo $game_id; ?>';
    var game_name = $("input[name='game_name']").val();
    var game_plat = $("select[name='game_plat']").val();
    var game_genre = $("select[name='game_genre']").val();
    var created_by = '<?php echo $curUser; ?>';
    var createOrEdit = '<?php echo $createOrEdit; ?>';

    if (game_name != "" && game_plat != "" && game_genre != "") {
        $.ajax({
            url: 'game_list_back.php',
            type: 'POST',
            data: {game_id: game_id, game_name: game_name, game_plat: game_plat, 
                  game_genre: game_genre, created_by: created_by, createOrEdit: createOrEdit
                  },
            success: function(res) {
                var data = JSON.parse(res);

                if (data['statusCode'] == 1) { //'1' is set as success code ('0' for fail)
                    Swal.fire({title: 'Success!', html: data['msg'], type: 'success'}).then(function(){
                      window.location.replace('game_list.php'); //Refresh page (location.reload is not used so that the GET variables are reset)
                    });
                } else {
                    Swal.fire({title: 'Error!', html: data['msg'], type: 'error'}); //Display error dialog
                }
            },
            error: function(res) {
                Swal.fire({title: 'Error!', html: 'We were unable to complete the operation.<br>Please try again later', type: 'error'});
            }
        });
      }
    });

    function edit_game(id) {
      var game_list_url = "game_list.php"

      // redirect to edit page
      window.location.replace(game_list_url + "?id=" + id);
    }


    function delete_game(id, name) { 
      var game_id = id;
      var game_name = name;

      Swal.fire({ //Display warning dialog
        title: 'WARNING!',
        html: 'This action cannot be reversed,<br>are you sure you want to delete <b>\'' + game_name + '\'</b>?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: 'game_list_delete_back.php',
            type: 'POST',
            data: {game_id: game_id},
            success: function(res) {
                var data = JSON.parse(res);

                if (data['statusCode'] == 1) { //'1' is set as success code ('0' for fail)
                    Swal.fire({title: 'Operation Complete!', html: data['msg'], //Display success dialog
                      type: 'success'}).then(function(){
                        location.reload(); //Return to dashboard once application has been rejected
                    })
                } else {
                    Swal.fire({title: 'Error!', html: data['msg'], type: 'error'}); //Display error dialog
                }
            },
            error: function(res) {
              Swal.fire({title: 'Error!', html: 'We were unable to complete the operation.<br>Please try again later', type: 'error'});
            }
          });
        }
      })
    }
  </script>

</body>

</html>