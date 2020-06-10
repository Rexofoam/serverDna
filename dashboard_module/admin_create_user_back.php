<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../login_module/vendor/autoload.php';

    include '../public/DBconnect.php';
    include '../public/passwordHelper.php';
    include '../public/callbackHelper.php';
    
    session_start();

    //Connection to database
    $con = DatabaseConn();

    //Access time
    $date = new DateTime();
	$date->add(new DateInterval('PT06H'));
    $AccessTime = $date->format('Y-m-d H:i:s');
    
    //Fetch user inputs
    $name = $_POST["name"]; 
    $userid = $_POST["userid"];
    $mobile_number = $_POST["phone"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    $birthday = $_POST["birthday"];
    $address = "";
    $city = $_POST["city"];
    $state = $_POST["state"];
    $password = generateRandomString();

    // Check if the same account exists
    
    $return_val = mysqli_query($con,"SELECT COUNT(*) AS 'Number' FROM `users` WHERE (email = '$email' OR mobile_number = '$mobile_number') AND status = 'authenticated'");

    $val_result = mysqli_fetch_array($return_val);

    if($val_result[0] > 0){
        $res = array(
                "statusCode" => 0, 
                "msg" => "<b>Registration Failed!</b><br>This email OR phone number is alreadyy in use. !"
            );
            
            echo json_encode($res);
    } else {

        //Add new user statement
        $sql = "INSERT INTO `users` VALUES (NULL, '$name', '$userid', '$mobile_number', '$email', 
                    '$password', '$birthday', '$gender', 'created', NULL, 
                    '$AccessTime', '$city', '$state');";

        if (!mysqli_query($con, $sql)) {
            echo "Error! Unable to connect to database";
            
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
            }
            catch (Exception $e){
            $res = array(
                "statusCode" => 0, 
                "msg" => "<b>Registration Failed!</b><br>Please try again later !"
            );
            
            echo json_encode($res);
            }

            if(!$mail->Send()) {
            $res = array(
                "statusCode" => 0, 
                "msg" => "<b>Registration Failed!</b><br>Please try again later !"
            );
            
            echo json_encode($res);
            } else {

            $res = array(
                "statusCode" => 1, 
                "msg" => "<b>Registration Success!</b><br>An authentication email has been sent to the associated email address"
            );
            
            echo json_encode($res);
          
            } 
        
    }
}

?>