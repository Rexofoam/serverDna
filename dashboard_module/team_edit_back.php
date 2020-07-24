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
    $team_id = $_POST['team_id'];
    $team_name = mysqli_real_escape_string($con, $_POST["team_name"]); 
    $games_arr = isset($_POST["games"]) ? $_POST["games"] : array();
    $team_capt_email = $_POST["team_capt"];
    $team_vice_email = trim($_POST["team_vice"]);
    $team_member_email_arr = $_POST["team_members"];
    $team_sub_email_arr = isset($_POST["team_subs"]) ? $_POST["team_subs"] : array();

    if (duplicateMembersExist($team_capt_email, $team_vice_email, $team_member_email_arr, $team_sub_email_arr)) {
        $res = array(
            "statusCode" => 0, 
            "msg" => "You have entered the same user in multiple fields.<br>Each member can only be assigned to one role.<br><br>Please make the necessary amendments and then try again."
        );

        echo json_encode($res);
    } else {
        $return_val = mysqli_query($con,"SELECT COUNT(*) AS 'Number' FROM `teams` WHERE UPPER('$team_name') = UPPER(team_name) AND `team_id` != '$team_id'");
        $val_result = mysqli_fetch_array($return_val);

        if($val_result[0] > 0){
            $res = array(
                "statusCode" => 0, 
                "msg" => "A team already exists with that team name!"
            );
    
            echo json_encode($res);
        } else {
            $NOUSERTXT = "NOUSER";
            $incorrect_email_arr = array(); //If any email address(es) don't have a corresponding user id, insert them into this array

            //Convert all emails to user ids
            $team_capt = findUserID($con, $team_capt_email, $NOUSERTXT);
            if ($team_capt == $NOUSERTXT) array_push($incorrect_email_arr, $team_capt_email);

            $team_vice = "";
            if ($team_vice_email != "") $team_vice = findUserID($con, $team_vice_email, $NOUSERTXT);
            if ($team_vice == $NOUSERTXT) array_push($incorrect_email_arr, $team_vice_email);

            $team_member_arr = array();
            $team_sub_arr = array();

            foreach($team_member_email_arr as $email) {
                $ret = findUserID($con, $email, $NOUSERTXT);

                if ($ret == $NOUSERTXT) array_push($incorrect_email_arr, $email);
                else array_push($team_member_arr, $ret);
            }

            foreach($team_sub_email_arr as $email) {
                $ret = findUserID($con, $email, $NOUSERTXT);
                
                if ($ret == $NOUSERTXT) array_push($incorrect_email_arr, $email);
                else array_push($team_sub_arr, $ret);
            }

            if (sizeof($incorrect_email_arr) > 0) { //If there are any incorrect emails
                $email_str = implode("<br>", $incorrect_email_arr);
                $msg = "The following email address(es) do not belong to any existing users:<br><br>".$email_str."<br><br>Please make the necessary changes and try again.";

                $res = array(
                    "statusCode" => 0, 
                    "msg" => $msg
                );
        
                echo json_encode($res);
            
            } else { //Only insert into db if no duplicate members in multiple roles, no existing team with same name, no non-existing emails
                $games = "";
        
                //Turning array into string
                for ($ctr = 0; $ctr < sizeof($games_arr); $ctr++) {
                    if ($ctr == 0) $games .= $games_arr[$ctr];
                    else $games .= ','.$games_arr[$ctr];
                }
            
                //Update team statement
                $sql = "UPDATE `teams` SET `team_name` = '$team_name', `games` = '$games', `updated_at` = '$AccessTime' WHERE `team_id` = '$team_id';";
            
                if (!mysqli_query($con, $sql)) {
                    $res = array(
                        "statusCode" => 0, 
                        "msg" => "We were unable to update your team details.<br>Please try again later"
                    );
            
                    echo json_encode($res);
            
                } else {
                    $userTeamStatement = "";
                    
                    //Delete previous user-team records
                    $userTeamStatement .= "DELETE FROM `user_teams` WHERE `team_id` = '$team_id';";

                    //Generate insert statements for every user
                    $userTeamStatement .= genUserTeamStatement($team_id, $team_capt, 'captain', $AccessTime, 'pending');
                    
                    if (isset($team_vice) && $team_vice != "") {
                        $userTeamStatement .= genUserTeamStatement($team_id, $team_vice, 'vice', $AccessTime, 'pending');
                    }

                    foreach($team_member_arr as $player) {
                        $userTeamStatement .= genUserTeamStatement($team_id, $player, 'player', $AccessTime, 'pending');
                    }

                    if (isset($team_sub_arr) && sizeof($team_sub_arr) > 0) {
                        foreach($team_sub_arr as $sub) {
                            $userTeamStatement .= genUserTeamStatement($team_id, $sub, 'substitute', $AccessTime, 'pending');
                        }
                    }
            
                    if (!mysqli_multi_query($con, $userTeamStatement)) {
                        $res = array(
                            "statusCode" => 0, 
                            "msg" => "An error was encountered sending invitations to newly added users. Please contact a site admin regarding this issue"
                        );
                
                        echo json_encode($res);
            
                    } else {
                        $res = array(
                            "statusCode" => 1, 
                            "msg" => "Your team details have been successfully updated and invitations have been sent to new team members."
                        );
                
                        echo json_encode($res);
                    }
                }
            } 
        }
    }

    //=========================================================================== FUNCTIONS ==============================================================

    //Function to check if the same user is included in multiple fields (capt, vice, members, etc)
    function duplicateMembersExist($team_capt, $team_vice, $team_member_arr, $team_sub_arr) {
        $duplicateMembers = false;

        if ($team_capt == $team_vice) { //Compare capt with vice
            $duplicateMembers = true;
        }

        if (in_array($team_capt, $team_member_arr) || in_array($team_capt, $team_sub_arr)) { //Compare capt with members and subs
            $duplicateMembers = true;
        }

        if (isset($team_vice) && $team_vice != "") {
            if (in_array($team_vice, $team_member_arr) || in_array($team_vice, $team_sub_arr)) { //Compare vice with members and subs
                $duplicateMembers = true;
            }
        }

        if (sizeof(array_intersect($team_member_arr, $team_sub_arr)) > 0) { //Compare members with subs
            $duplicateMembers = true;
        }

        return $duplicateMembers;
    }

    function findUserID($con, $email, $NOUSERTXT) { //Used to find the corresponding user id of an email address
        $sql_user = mysqli_fetch_array(mysqli_query($con, "SELECT id FROM users WHERE email = '$email'"));
        
        if (isset($sql_user['id']) && $sql_user['id'] != '') return $sql_user['id'];
        else return $NOUSERTXT;
    }

    function genUserTeamStatement($team_id, $user_id, $role, $AccessTime, $status) {
        $sql = "INSERT INTO `user_teams` VALUES (NULL, '$team_id', '$user_id', '$role', '$AccessTime', '$status', NULL);";
        return $sql;
    }

?>