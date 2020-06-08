<?php

    include '../public/DBconnect.php';
    session_start();

    //Connection to database
    $con = DatabaseConn();

    //Access time
    $date = new DateTime();
	$date->add(new DateInterval('PT06H'));
    $AccessTime = $date->format('Y-m-d H:i:s');
    
    //Fetch user inputs
    $user_id = $_POST["user_id"];
    $name = $_POST["name"]; 
    $userid = $_POST["userid"];
    $mobile_number = $_POST["phone"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    $birthday = $_POST["birthday"];
    $address = "";
    $city = $_POST["city"];
    $state = $_POST["state"];

    // Check if the same account exists
    
    $return_val = mysqli_query($con,"SELECT COUNT(*) AS 'Number' FROM `users` WHERE (email = '$email' OR mobile_number = '$mobile_number') AND status = 'authenticated' AND id != '$user_id'");

    $val_result = mysqli_fetch_array($return_val);

    if($val_result[0] > 0){
        
        $res = array(
                "statusCode" => 0, 
                "msg" => "<b>Error updating user with existing email or mobile number"
            );
        echo json_encode($res);
    } else {

        //Add new user statement
        $sql = "UPDATE `users` SET `full_name` = '$name', `user_id` = '$userid', `mobile_number` = '$mobile_number', `email` = '$email', `gender` = '$gender', `DoB` = $birthday, `updated_at` = '$AccessTime', `city` = '$city', `state` = '$state' WHERE id = '$user_id'";

        if (!mysqli_query($con, $sql)) {
            $res = array(
                "statusCode" => 0, 
                "msg" => "<b>Unknown error while updating user"
            );
            
            echo json_encode($res);
            
        } else {
            $res = array(
                "statusCode" => 1, 
                "msg" => "<b>Account Updated"
            );
            
            echo json_encode($res);
            
        } 
        
    }

?>