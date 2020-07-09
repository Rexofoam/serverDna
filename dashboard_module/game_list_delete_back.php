<?php

    include '../public/DBconnect.php';
    session_start();

    //Connection to database
    $con = DatabaseConn();

    //Access time
    // $date = new DateTime();
	// $date->add(new DateInterval('PT06H'));
    // $AccessTime = $date->format('Y-m-d H:i:s');
    
    $game_id = $_POST['game_id'];

    //Update event application statement
    $sql = "DELETE FROM `games` WHERE game_id = '$game_id'";

    if (!mysqli_query($con, $sql)) {
        $res = array(
            "statusCode" => 0, 
            "msg" => "We were unable to perform the operation.<br>Please try again later"
        );
        
        echo json_encode($res);
        
    } else {
        $res = array(
            "statusCode" => 1, 
            "msg" => "The selected game record has been deleted"
        );
        
        echo json_encode($res);
        
    } 
        
?>