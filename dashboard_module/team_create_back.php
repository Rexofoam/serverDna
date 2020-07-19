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
    $team_name = mysqli_real_escape_string($con, $_POST["team_name"]); 
    $games_arr = isset($_POST["games"]) ? $_POST["games"] : array();
    $team_capt = $_POST["team_capt"];
    $team_vice = $_POST["team_vice"];
    $team_member_arr = $_POST["team_members"];
    $team_sub_arr = isset($_POST["team_subs"]) ? $_POST["team_subs"] : array();
    $created_by = $_POST["created_by"];
    $status = 'pending';

    if (duplicateMembersExist($team_capt, $team_vice, $team_member_arr, $team_sub_arr)) {
        $res = array(
            "statusCode" => 0, 
            "msg" => "You have entered the same user in multiple fields.<br>Each member can only be assigned to one role.<br><br>Please make the necessary amendments and then try again."
        );

        echo json_encode($res);
    } else {
        $return_val = mysqli_query($con,"SELECT COUNT(*) AS 'Number' FROM `teams` WHERE UPPER('$team_name') = UPPER(team_name) AND status IN ('pending', 'authenticated')");
        $val_result = mysqli_fetch_array($return_val);

        if($val_result[0] > 0){
            $res = array(
                "statusCode" => 0, 
                "msg" => "A team already exists with that team name!"
            );
    
            echo json_encode($res);
        } else {
            $games = "";
        
            //Turning array into string
            for ($ctr = 0; $ctr < sizeof($games_arr); $ctr++) {
                if ($ctr == 0) $games .= $games_arr[$ctr];
                else $games .= ','.$games_arr[$ctr];
            }
        
            //Add new team statement
            $sql = "INSERT INTO `teams` VALUES (NULL, '$team_name', '$games', '$AccessTime', '$created_by', 
                    '$status', NULL, NULL);";
        
            if (!mysqli_query($con, $sql)) {
                $res = array(
                    "statusCode" => 0, 
                    "msg" => "We were unable to submit your team details.<br>Please try again later"
                );
        
                echo json_encode($res);
        
            } else {
                //Get the last inserted id
                $team_id = mysqli_insert_id($con);
                $userTeamStatement = "";

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
                        "msg" => "An error was encountered sending invitations to the listed users. Please contact a site admin regarding this issue"
                    );
            
                    echo json_encode($res);
        
                } else {
                    $res = array(
                        "statusCode" => 1, 
                        "msg" => "Your team details have been successfully submitted and invitations have been sent to all team members.<br><br>Team creation will be completed once all members have accepted their invitations."
                    );
            
                    echo json_encode($res);
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

    function genUserTeamStatement($team_id, $user_id, $role, $AccessTime, $status) {
        $sql = "INSERT INTO `user_teams` VALUES (NULL, '$team_id', '$user_id', '$role', '$AccessTime', '$status', NULL);";
        return $sql;
    }

?>