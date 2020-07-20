<?php

    include '../public/DBconnect.php';
    session_start();

    //file upload variables
    $target_dir = "../public/images/";
    $file = $_FILES['fileToUpload'];

    $fileName = $_FILES['fileToUpload']['name'];
    $fileTmpName = $_FILES['fileToUpload']['tmp_name'];
    $fileSize = $_FILES['fileToUpload']['size'];
    $fileError = $_FILES['fileToUpload']['error'];
    $fileType = $_FILES['fileToUpload']['type'];
    $fileDestination = "";

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

    // Image Upload script

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 2000000) {

                    // change image name to micro-second naming
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $fileDestination = '../public/images/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);

                } else {
                    $_SESSION['update_response'] = "Image upload size to large !";
                    header('Location: profile_details.php');
                    

                }
            } else {
                $_SESSION['update_response'] = "Unknown image upload issue !";
                header('Location: profile_details.php');
              

            }
        } else {
            $_SESSION['update_response'] = "Invalid image extension !";
            header('Location: profile_details.php');
            

        }

    // End of image upload
    
    $return_val = mysqli_query($con,"SELECT COUNT(*) AS 'Number' FROM `users` WHERE (email = '$email' OR mobile_number = '$mobile_number') AND status = 'authenticated' AND id != '$user_id'");

    $val_result = mysqli_fetch_array($return_val);

    if($val_result[0] > 0){
        $_SESSION['update_response'] = "Email or mobile number already in use !";
        header('Location: profile_details.php');
        

    } else {

        //Add new user statement
        $sql = "UPDATE `users` SET `full_name` = '$name', `mobile_number` = '$mobile_number', `email` = '$email', `gender` = '$gender', `DoB` = '$birthday', `updated_at` = '$AccessTime', `city` = '$city', `state` = '$state', `image_url` = '$fileDestination' WHERE id = '$user_id'";

        if (!mysqli_query($con, $sql)) {

            $_SESSION['update_response'] = "Unknown update issue !";
            header('Location: profile_details.php');
            
        } else {

            $_SESSION['update_response'] = "success";
            header('Location: profile_details.php');
            
        } 
        
    }

?>