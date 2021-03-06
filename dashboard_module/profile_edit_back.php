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
    $user_id = mysqli_real_escape_string($con, $_POST["user_id"]);
    $name = mysqli_real_escape_string($con, $_POST["name"]);
    $mobile_number = $_POST["phone"];
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $gender = $_POST["gender"];
    $birthday = $_POST["birthday"];
    $city = mysqli_real_escape_string($con, $_POST["city"]);
    $state = $_POST["state"];

    // Check if the same account exists
    
    $return_val = mysqli_query($con,"SELECT COUNT(*) AS 'Number' FROM `users` WHERE (email = '$email' OR mobile_number = '$mobile_number') AND status = 'authenticated' AND id != '$user_id'");

    $val_result = mysqli_fetch_array($return_val);

    if($val_result[0] > 0){
        
        $res = array(
                "statusCode" => 0, 
                "msg" => "Failed to save changes.<br>Another user exists with the same email or mobile number"
            );
        echo json_encode($res);
    } else {

        //Add new user statement
        $sql = "UPDATE `users` SET `full_name` = '$name', `mobile_number` = '$mobile_number', `email` = '$email', `gender` = '$gender', `DoB` = '$birthday', `updated_at` = '$AccessTime', `city` = '$city', `state` = '$state' WHERE id = '$user_id'";

        if (!mysqli_query($con, $sql)) {
            $res = array(
                "statusCode" => 0, 
                "msg" => "We were unable to perform the operation.<br>Please try again later"
            );
            
            echo json_encode($res);
            
        } else {
            $res = array(
                "statusCode" => 1, 
                "msg" => "Your account details have been updated"
            );
            
            echo json_encode($res);
            
        } 
        
    }

?>