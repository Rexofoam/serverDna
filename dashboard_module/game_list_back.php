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
    $game_id = $_POST["game_id"];
    $game_name = mysqli_real_escape_string($con, $_POST["game_name"]); 
    $game_plat_arr = $_POST["game_plat"];
    $game_genre_arr = $_POST["game_genre"];
    $created_by = $_POST["created_by"];
    $createOrEdit = $_POST["createOrEdit"]; //Flag to select INSERT or UPDATE operation (0 - create/insert, 1 - update)

    $game_platforms = "";
    $game_genres = "";

    //Turning arrays into strings for event admins and staff
    for ($ctr = 0; $ctr < sizeof($game_plat_arr); $ctr++) {
        if ($ctr == 0) $game_platforms .= $game_plat_arr[$ctr];
        else $game_platforms .= ','.$game_plat_arr[$ctr];
    }

    for ($ctr = 0; $ctr < sizeof($game_genre_arr); $ctr++) {
        if ($ctr == 0) $game_genres .= $game_genre_arr[$ctr];
        else $game_genres .= ','.$game_genre_arr[$ctr];
    }

    if ($createOrEdit == 0) { //If inserting new record
        //Add new game statement
        $sql = "INSERT INTO `games` VALUES (NULL, '$game_name', '$game_platforms', '$game_genres', '$created_by', 
                '$AccessTime', NULL, NULL);";

        if (!mysqli_query($con, $sql)) {
            $res = array(
                "statusCode" => 0, 
                "msg" => "We were unable to submit your game details.<br>Please try again later"
            );

            echo json_encode($res);

        } else {
            $res = array(
                "statusCode" => 1, 
                "msg" => "New game registered and added to site database"
            );

            echo json_encode($res);
        }
    } else { //If updating existing record
        //Update game statement
        $sql = "UPDATE `games` SET `game_name` = '$game_name', `platforms` = '$game_platforms', `genres` = '$game_genres' 
                WHERE `game_id` = '$game_id'";

        if (!mysqli_query($con, $sql)) {
            $res = array(
                "statusCode" => 0, 
                "msg" => "We were unable to update your game details.<br>Please try again later"
            );

            echo json_encode($res);

        } else {
            $res = array(
                "statusCode" => 1, 
                "msg" => "Game details updated"
            );

            echo json_encode($res);
        }
    }
?>