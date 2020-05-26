<!DOCTYPE html>
<html>
<body>
<?php
	include 'DBconnect.php';
	include 'passwordHelper.php';
  	session_start();

  	//connection to database
  	$con = DatabaseConn();

  	// Get user login time
  	$date = new DateTime();
	$date->add(new DateInterval('PT06H'));
	$AccessTime = $date->format('Y-m-d H:i:s');

	
    $name = $_POST["name"]; 
    $mobile_number = $_POST["phone"];
    $email = $_POST["email"]; 
    $password = generateRandomString();

    echo $name;
    echo $mobile_number;
    echo $email;
    echo $password;
    
    /*
	$sql = mysqli_query($con,"INSERT INTO users VALUES ('$name', '$mobile_number', '$email', );");

	$result = mysqli_fetch_array($sql);
	
	if($result == null) {
		$_SESSION["Credential_text"] = "Incorrect Username or Password !!!";
    	header("Location: index.php");
	}

	if($result['id'] == 1) {
		echo "Sudo admin account";
	}
	else {
		
	}
	*/
	

?>

</body>
</html>