<?php

    include '../public/DBconnect.php';
    session_start();

    //Connection to database
    $con = DatabaseConn();

    //Access time
    $date = new DateTime();
	$date->add(new DateInterval('PT06H'));
    $AccessTime = $date->format('Y-m-d H:i:s');
    
    $app_id = $_POST['app_id'];
    $status = "rejected";

    //Update event application statement
    $sql = "UPDATE `event_application` SET `status` = '$status', `status_upd_at` = '$AccessTime' WHERE app_id = '$app_id'";

    if (!mysqli_query($con, $sql)) {
        $res = array(
            "statusCode" => 0, 
            "msg" => "<b>Error!</b><br>We were unable to perform the operation. Please try again later"
        );
        
        echo json_encode($res);
        
    } else {
        $res = array(
            "statusCode" => 1, 
            "msg" => "Event application has been rejected and will no longer appear in the event applications list"
        );
        
        echo json_encode($res);
        
    } 
        
?>