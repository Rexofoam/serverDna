<!DOCTYPE html>
<html>
<body>
<?php
	include 'DBconnect.php';
  	session_start();

  	//connection to database
  	$con = DatabaseConn();

  	// Get user login time
  	$date = new DateTime();
	$date->add(new DateInterval('PT06H'));
	$AccessTime = $date->format('Y-m-d H:i:s');

	
    $Email = $_POST["email"]; 
    $password = $_POST["password"];
    

	$sql = mysqli_query($con,"SELECT * FROM users WHERE email = '$Email' AND password = '$password'");

	$result = mysqli_fetch_array($sql);
	
	if($result == null) {
		$_SESSION["Credential_text"] = "Incorrect Username or Password !!!";
    	header("Location: index.php");
	}
	/*test echo (remoavable)*/
	echo $result['full_name'];
	echo $result['status'];

	if($result['status'] == "SUDO ADMIN") {
		echo "Sudo admin account";
	}
	else {

	}

?>

</body>
</html>