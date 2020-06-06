<?php
    // TODO - Move these files out of login module
    use \login_module\PHPMailer\PHPMailer\PHPMailer;
    use \login_module\PHPMailer\PHPMailer\Exception;

    require '../login_module/vendor/autoload.php';

    include '../login_module/DBconnect.php';
    include '../login_module/passwordHelper.php';
    include '../login_module/callbackHelper.php';
    
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
        //Same login details exist in database
        //$_SESSION["Reg_status_text"] = "<b>Registration Failed!</b><br>An account with the same email/phone number already exists!";
        //header("Location: admin_create_user_front.php");
        echo "<b>Registration Failed!</b><br>An account with the same email/phone number already exists!";
    } else {

        //Add new user statement
        $sql = "INSERT INTO `users` VALUES (NULL, '$name', '$mobile_number', '$email', 
                    '$password', '$birthday', '$gender', '$address', 'created', NULL, 
                    '$AccessTime', '$city', '$state');";

        if (!mysqli_query($con, $sql)) {
            echo "Error! Unable to connect to database";
            //$_SESSION["Reg_status_text"] = "Error! Unable to connect to database";
            //console.log(mysqli_error($con));
            //header("Location: admin_create_user_front.php");
        } else {
            $res = array(
                "statusCode" => 1, 
                "msg" => "<b>Registration Success!</b><br>An authentication email has been sent to the associated email address"
            );
            
            echo json_encode($res);

            //TODO - Uncomment after PHPMailer is fixed
            /*$fallbackURL = getCreateUserAccount($con->insert_id);

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
                // Registration failed
                //$_SESSION["Reg_status_text"] = "<b>Registration Failed!</b><br>Please try again later";
                //header("Location: admin_create_user_front.php"); 
                echo "<b>Registration Failed!</b><br>Please try again later";
            }

            if(!$mail->Send()) {
                // Registration failed
                //$_SESSION["Reg_status_text"] = "<b>egistration Failed!</b><br>Please try again later";
                //header("Location: admin_create_user_front.php");
                echo "<b>Registration Failed!</b><br>Please try again later";
            } else {
                // Registration success
                //$_SESSION["Reg_status_text"] = "<b>Registration Success!</b><br>An authentication email has been sent to the associated email address";
                //header("Location: admin_create_user_front.php"); 
                echo "<b>Registration Success!</b><br>An authentication email has been sent to the associated email address";
            }
          */  
        } 
        
    }

?>