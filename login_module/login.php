<!DOCTYPE html>
<html>
<body>
<?php
	include '../public/DBconnect.php';
  	session_start();

  	//connection to database
  	$con = DatabaseConn();

  	// Get user login time
  	$date = new DateTime();
	$date->add(new DateInterval('PT06H'));
	$AccessTime = $date->format('Y-m-d H:i:s');

	
    $Email = $_POST["email"]; 
    $password = sha1($_POST["password"]);
    

	$sql = mysqli_query($con,"SELECT * FROM users WHERE email = '$Email' AND password = '$password'");

	$result = mysqli_fetch_array($sql);
	
	if($result == null) {
		$_SESSION["Credential_text"] = "Incorrect Username or Password !!!";
    	header("Location: index.php");
	} else {
		$_SESSION["Curr_user"] = $result['id'];

		if($result['is_admin'] == 1) {
			header("Location: ../dashboard_module/dashboard.html");
		} else {
			header("Location: ../user_dashboard_module/dashboard.html");
		}
	}


?>

</body>
</html>