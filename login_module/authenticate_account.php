<?php

	include 'DBconnect.php';
	session_start();


	$con = DatabaseConn();
	$user_id = $_POST["id"]; 
	$password1 = $_POST["psw1"]; 
	$password2 = $_POST["psw2"]; 

	if($user_id == "" || $user_id == null) {
		$_SESSION["fallback_msg"] = "ERROR 206. Invalid user ID";
    	header("Location: authenticate.php?id=$user_id");
	}

	if($password1 != $password2) {
		$_SESSION["fallback_msg"] = "Password does not match!";
    	header("Location: authenticate.php?id=$user_id");
	} else {
		$password = sha1($password1);
		$sql = "UPDATE users SET `status` = 'authenticated', `password` = '$password' WHERE `id` = '$user_id'";

        if(!mysqli_query($con,$sql))
        {
            $_SESSION["fallback_msg"] = "Failed to authenticate, Try again later !";
            header("Location: authenticate.php?id=$user_id");

        } else {
        	$_SESSION["Credential_text"] = "Account authenticated, you can may login.";
    		header("Location: index.php");
        }
	}
?>