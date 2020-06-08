<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    include '../public/DBconnect.php';
    include '../public/passwordHelper.php';
    include '../public/callbackHelper.php';

    session_start();

    //connection to database
    $con = DatabaseConn();

    // Get user login time
    $date = new DateTime();
    $date->add(new DateInterval('PT06H'));
    $AccessTime = $date->format('Y-m-d H:i:s');

    // Fetch user inputs
    $name = $_POST["name"];
    $userId = $_POST["user_id"];  
    $mobile_number = $_POST["phone"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    $birthday = $_POST["birthday"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $password = generateRandomString();
    

    // Check is account exists
    
    $return_val = mysqli_query($con,"SELECT COUNT(*) AS 'Number' FROM `users` WHERE (email = '$email' OR mobile_number = '$mobile_number') AND status = 'authenticated'");

    $val_result = mysqli_fetch_array($return_val);

    if($val_result[0] > 0){

        $_SESSION["Credential_text"] = "This Email has already been registered!";
        header("Location: index.php");

    } else {

    $sql = "INSERT INTO `users` VALUES (NULL, '$name', '$userId', '$mobile_number', '$email', '$password', '$birthday', '$gender','created', NULL, '$AccessTime', '$city', '$state');";

        if(!mysqli_query($con,$sql))
        {

            $_SESSION["Credential_text"] = "Failed to register. Please try again later!";
            header("Location: index.php");

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
                            '<br><br> You have recently registered for an account under ServerDNA,<br>
                            To get started with your account please click the button below. <br><br>
                            <a style="padding: 10px; background-color: #2bb673; border: transparent; color: white;" href="'.$fallbackURL.'">Authenticate Account</a> <br><br>
                            If you did not create this account, you may ignore this email, your account<br>
                            will be deactivated after 7 days.<br><br>
                            Regards,<br>ServerDNA Team.';
            $mail->AddAddress($email);

            $mail->Send();
            }
            catch (Exception $e){
                $_SESSION["Credential_text"] =  'Failed to register. Please try again later';
                header("Location: index.php"); 
            }

            if(!$mail->Send()) {
                $_SESSION["Credential_text"] =  'Failed to register. Please try again later';
                header("Location: index.php");
            } else {
            
            $_SESSION["Credential_text"] = "Registration success! Check your email, to authenticate!";
            header("Location: index.php"); 
            
            }
            
        } 
        
    }

?>