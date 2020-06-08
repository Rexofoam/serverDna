<?php
    include '../public/DBconnect.php';

    session_start();

    //connection to database
    $con = DatabaseConn();
    $userID = $_GET['id'];
    
    
    $return_val = mysqli_query($con,"SELECT COUNT(*) AS 'Number' FROM `users` WHERE 'id' = $userID");

    $val_result = mysqli_fetch_array($return_val);

    if($val_result[0] > 0){

        echo "NO USER DETECTED";

    } else {

    $sql = "DELETE FROM `users` WHERE `users`.`id` = $userID";

        if(!mysqli_query($con,$sql))
        {

            echo "NO USER DETECTED";

        } else {
            
            header("Location: user_list.php"); 
            
        }
            
    } 
        

?>