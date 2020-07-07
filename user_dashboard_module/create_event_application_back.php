<?php
    require '../login_module/vendor/autoload.php';

    include '../public/DBconnect.php';
    include '../public/passwordHelper.php';
    include '../public/callbackHelper.php';
    
    session_start();

    //Connection to database
    $con = DatabaseConn();

    //Create time
    $date = new DateTime();
	$date->add(new DateInterval('PT06H'));
    $AccessTime = $date->format('Y-m-d H:i:s');
    
    //Fetch user inputs
    $app_name = mysqli_real_escape_string($con, $_POST["app_name"]); 
    $app_desc = mysqli_real_escape_string($con, $_POST["app_desc"]);
    $org = mysqli_real_escape_string($con, $_POST["org"]);
    $game = $_POST["game"];
    $teams = $_POST["teams"];
    $venue = mysqli_real_escape_string($con, $_POST["venue"]);
    $city = mysqli_real_escape_string($con, $_POST["city"]);
    $state = $_POST["state"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    $contact_method = $_POST["contact_method"];
    $phone_select = $_POST["phone_select"];
    $contact_no = $_POST["contact_no"];
    $email_select = $_POST["email_select"];
    $email_address = mysqli_real_escape_string($con, $_POST["email_address"]);
    $created_by = $_POST["created_by"];

    // If user selects call or whatsapp as preferred contact method but doesnt enter a number
    if (($contact_method == 'CALL' || $contact_method == 'WHATSAPP') && ($contact_no == '-' || $contact_no == '')) {
        $res = array(
            "statusCode" => 0, 
            "msg" => "<b>Warning!</b><br>You have selected either Call or Whatsapp as your preferred method of contact, but have not entered a mobile number to contact.<br><br>Please enter a phone number or change your preferred method of contact to proceed."
        );
        
        echo json_encode($res);
    } else if ($contact_method == 'EMAIL' && ($email_address == '-' || $email_address == '')) { //If user selects email as preferred but doesn enter an email
        $res = array(
            "statusCode" => 0, 
            "msg" => "<b>Warning!</b><br>You have selected Email as your preferred method of contact, but have not entered an email address to contact.<br><br>Please enter a email address or change your preferred method of contact to proceed."
        );
        
        echo json_encode($res);
    } else {
        //Add new event application statement
        $sql = "INSERT INTO `event_application` VALUES (NULL, '$app_name', '$app_desc', '$game', '$teams', 
                '$startDate', '$endDate', '$venue', '$city', '$state', '$org', '$created_by', 
                '$AccessTime', '$contact_method', '$contact_no', '$email_address', 'pending',
                NULL, NULL);";

        if (!mysqli_query($con, $sql)) {
            $res = array(
            "statusCode" => 0, 
            "msg" => "<b>Error!</b><br>We were unable to submit your application details. Please try again later"
            );

            echo json_encode($res);

        } else {
            $res = array(
            "statusCode" => 1, 
            "msg" => "<b>Success!</b><br>Your event application has been submitted and will be reviewed by our administrators.<br><br>Please wait to be contacted to finalize the event details"
            );

            echo json_encode($res);
        }
    }

?>