<?php
		/* get connection to database */
		function DatabaseConn(){
			// params (localhost, user, password)
			$con = mysqli_connect('127.0.0.1','root','');

			if(!$con){

		    	die("Failed to connect to MySQL server");

		   	}

			if(!mysqli_select_db($con,'serverdna')){

			    die("Failed to connect to database");
			}
			return $con;
		}
?>