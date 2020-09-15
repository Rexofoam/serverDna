<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../login_module/vendor/autoload.php';

    include '../public/DBconnect.php';
    include '../public/passwordHelper.php';
    include '../public/callbackHelper.php';
    
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
    $name = mysqli_real_escape_string($con, $_POST["name"]); 
    $userid = mysqli_real_escape_string($con, $_POST["userid"]);
    $mobile_number = $_POST["phone"];
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $gender = $_POST["gender"];
    $birthday = $_POST["birthday"];
    $city = mysqli_real_escape_string($con, $_POST["city"]);
    $state = $_POST["state"];
    $password = generateRandomString();

    // Check if the same account exists
    
    $return_val = mysqli_query($con,"SELECT COUNT(*) AS 'Number' FROM `users` WHERE (email = '$email' OR mobile_number = '$mobile_number') AND status = 'authenticated'");

    $val_result = mysqli_fetch_array($return_val);

    if($val_result[0] > 0){
        $_SESSION['update_response'] = "Email or mobile number already in use";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {

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
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    

                }
            } else {
                $_SESSION['update_response'] = "Unknown image upload issue !";
                header('Location: ' . $_SERVER['HTTP_REFERER']);
              

            }
        } else {
            $_SESSION['update_response'] = "Invalid image extension !";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }

    // End of image upload

        //Add new user statement
        $sql = "INSERT INTO `users` VALUES (NULL, '$name', '$userid', '$mobile_number', '$email', '$password', '$birthday', '$gender', 'created', '$AccessTime', NULL, '$AccessTime', '$city', '$state', 0, '$fileDestination');";

        if (!mysqli_query($con, $sql)) {
            $_SESSION['update_response'] = "Unknown error occured. Please try again later !";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            
        } else {
            $fallbackURL = getCreateUserAccount($con->insert_id);

            $mail = new PHPMailer(true);
            
            try{
                $mail->isSMTP();
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'tls';
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->isHTML(true);
                $mail->Username = 'rexofoamjio@gmail.com';
                $mail->Password = 'malphiteSucks';
                $mail->setFrom('no-reply@JIO.com', 'no-reply');


                $mail->Subject = 'ServerDNA Registration';
                $mail->Body = 'Greetings,'.'Mr/Mrs.'.$name.
                                '<br><br> You have recently been registered for an account under ServerDNA by a site admin,<br>
                                To get started with your account please click the button below. <br><br>
                                <a style="padding: 10px; background-color: #2bb673; border: transparent; color: white;" href="'.$fallbackURL.'">Authenticate Account</a> <br><br>
                                If you do not wish to proceed with account creation, you may ignore this email, your account<br>
                                will be deactivated after 7 days.<br><br>
                                Regards,<br>ServerDNA Team.';
                $mail->AddAddress($email);

                $mail->Send();
                $_SESSION['update_response'] = "Account succesfully created !";
                header('Location: user_list.php');
            }
            catch (Exception $e){
                $_SESSION['update_response'] = "Unknown error occured. Please try again later !";
                header('Location: ' . $_SERVER['HTTP_REFERER']);

            if(!$mail->Send()) {
                $_SESSION['update_response'] = "Unknown error occured. Please try again later !";
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            
        
            } else {
                $_SESSION['update_response'] = "Unknown error occured. Please try again later !";
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } 
        
        }
    }
}

?>