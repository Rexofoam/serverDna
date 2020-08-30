<?php
	include '../public/DBconnect.php';
  	session_start();

  	//connection to database
  	$con = DatabaseConn();
  	$userID = $_SESSION["Curr_user"];
  	$teamName = $_SESSION["teamName"];
  	$notificationID = $_SESSION["notification_id"];

  	// Get user login time
  	$date = new DateTime();
	$date->add(new DateInterval('PT06H'));
	$AccessTime = $date->format('Y-m-d H:i:s');

	$sql = mysqli_query($con,"SELECT * FROM teams WHERE team_name = '$teamName';");

	$result = mysqli_fetch_array($sql);
	
	if($result == null) {
    	header("Location: dashboard.php");
	} else {
		$team_id = $result['team_id'];

		$sql_accept = mysqli_query($con,"UPDATE `user_teams` SET status = 'rejected' WHERE team_id = '$team_id' AND user_id = '$userID';");
		$notification_delete = mysqli_query($con,"UPDATE `notification` SET delete_at = '$AccessTime' WHERE id = '$notificationID';");

		if (!mysqli_query($con, $sql_accept)) {

			if (!mysqli_query($con, $notification_delete)) {
            $_SESSION['update_response'] = "Rejected team invitation.";
            header("Location: team_list.php");
        	} else {
            $_SESSION['update_response'] = "Rejected team invitation.";
            header("Location: team_list.php");
        	}

        } else {

	        if (!mysqli_query($con, $notification_delete)) {
            $_SESSION['update_response'] = "Rejected team invitation.";
            header("Location: team_list.php");
	        } else {
            $_SESSION['update_response'] = "Rejected team invitation.";
            header("Location: team_list.php");
	        }

        }

	}


?>