<?php
    require '../login_module/vendor/autoload.php';

    include '../public/DBconnect.php';
    include '../public/passwordHelper.php';
    include '../public/callbackHelper.php';
    
    session_start();

    //Connection to database
    $con = DatabaseConn();
    
    //Create time
    $date = new DateTime();
	$date->add(new DateInterval('PT06H'));
    $AccessTime = $date->format('Y-m-d H:i:s');
    
    //Fetch user inputs
    $ev_name = mysqli_real_escape_string($con, $_POST["ev_name"]); 
    $ev_desc = mysqli_real_escape_string($con, $_POST["ev_desc"]);
    $ev_type = $_POST["ev_type"];
    $org = mysqli_real_escape_string($con, $_POST["org"]);
    $game = $_POST["game"];
    $reg_type = $_POST['reg_type'];
    $reg_max = $_POST['reg_max'];
    $venue = mysqli_real_escape_string($con, $_POST["venue"]);
    $city = mysqli_real_escape_string($con, $_POST["city"]);
    $state = $_POST["state"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    $ev_admins_arr = $_POST["ev_admins"];
    $ev_staff_arr = isset($_POST["ev_staff"]) ? $_POST["ev_staff"] : array();
    $applied_by = $_POST["applied_by"];
    $approved_by = $_POST["approved_by"];
    $app_id = $_POST["app_id"];

    $ev_admins = "";
    $ev_staff = "";

    //Turning arrays into strings for event admins and staff
    for ($ctr = 0; $ctr < sizeof($ev_admins_arr); $ctr++) {
        if ($ctr == 0) $ev_admins .= $ev_admins_arr[$ctr];
        else $ev_admins .= ','.$ev_admins_arr[$ctr];
    }

    for ($ctr = 0; $ctr < sizeof($ev_staff_arr); $ctr++) {
        if ($ctr == 0) $ev_staff .= $ev_staff_arr[$ctr];
        else $ev_staff .= ','.$ev_staff_arr[$ctr];
    }

    //Add new event statement
    $sql = "INSERT INTO `events` VALUES (NULL, '$ev_name', '$ev_desc', '$ev_type', '$game', 
            '$reg_type', '$reg_max', '0', '$startDate', '$endDate', '$venue', '$city', '$state', '$org', 
            '$ev_admins', '$ev_staff', '$applied_by', '$approved_by', '$AccessTime', '$app_id', 'open',
            NULL, NULL);";

    if (!mysqli_query($con, $sql)) {
        $res = array(
            "statusCode" => 0, 
            "msg" => "We were unable to submit your event details.<br>Please try again later"
        );

        echo json_encode($res);

    } else {
        //Update event application statement
        $sql2 = "UPDATE `event_application` SET `status` = 'approved', `status_upd_at` = '$AccessTime' WHERE app_id = '$app_id'";

        if (!mysqli_query($con, $sql2)) {
            $res = array(
                "statusCode" => 0, 
                "msg" => "Event successfully created but event application could not be updated. Please contact a site admin regarding this issue"
            );
    
            echo json_encode($res);

        } else {
            $res = array(
                "statusCode" => 1, 
                "msg" => "Event details have been finalized and the event page is now available for viewing and management by related users"
            );
    
            echo json_encode($res);
        }
    }

?>