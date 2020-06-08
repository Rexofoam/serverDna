<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login to ServerDNA</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" href="css/form.css" />
<!--===============================================================================================-->
</head>
<body>
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100">
				<form class="login100-form validate-form" action="login.php" method="post">
					<span class="login100-form-logo">
						<img src='images/logo.png'>
					</span>

					<span class="login100-form-title p-b-34 p-t-27">
						Log in
					</span>

					<p style="text-align: center; color:white">
						<?php 
							session_start();
					      	if(isset($_SESSION["Credential_text"])){
					      		echo $_SESSION["Credential_text"];
					      		$_SESSION["Credential_text"] = "";
					      	}
					      	session_destroy();
			      		?>
			      	</p>

					<div class="wrap-input100 validate-input" data-validate = "Enter email">
						<input class="input100" type="text" name="email" placeholder="Email">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>

					<div class="contact100-form-checkbox">
						<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
						<label class="label-checkbox100" for="ckb1">
							Remember me
						</label>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="text-center p-t-90">
						<a class="txt1" href="#" onclick="document.getElementById('id01').style.display='block'">
							Sign up, here!
						</a>
						<br>
						<a class="txt1" href="#">
							Forgot Password?
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- FORM SECTION -->
	<div id="id01" class="modal">
  		<form class="modal-content animate" action="user_create.php" method="post">
			<div class="imgcontainer">
			    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
			     <img src="images/user-icon.png" alt="Avatar" class="avatar" style="max-height: 150px; width: auto">
			     <h3 class="text-white">New user</h3>
			</div>

			<div class="containerForm">
				<label for="name" class="text-white"><b>Full Name</b></label>
			    <input type="textForm" name="name" required>

			    <label for="name" class="text-white"><b>User ID (Optional)</b></label>
			    <input type="textForm" name="user_id">

			    <label for="phone" class="text-white"><b>Phone Number</b></label>
			    <input type="textForm" name="phone" required>

			    <label for="email" class="text-white"><b>Email</b></label>
			    <input type="textForm" name="email" required>

			    <div class="row" style="margin: 5px 0px 5px 0px">
				    <label class="text-white" style="margin-right: 190px"><b>Gender</b></label>
				    <label class="text-white"><b>Date of Birth</b></label>
				</div>
			    <div class="row" style="margin: 5px 0px 5px 0px">
				    <select name="gender" id="gender" style="margin-right: 50px;" placeholder="Gender" required>
					  <option value="male">Male</option>
					  <option value="female">Female</option>
					</select>

				    <input type="date" id="birthday" name="birthday" required>
				</div>
			    <div class="row" style="margin: 5px 0px 5px 0px">
				    <label class="text-white" style="margin-right: 270px"><b>City</b></label>
				    <label class="text-white"><b>State</b></label>
				</div>
			    <div class="row" style="margin: 5px 0px 5px 0px">
				    <input type="half-text" name="city" style="margin-right: 50px" required>
				    <select name="state" id="state" style="min-width: 250px" required>
					  <option value="PERLIS">Perlis</option>
                      <option value="PERAK">Perak</option>
                      <option value="KEDAH">Kedah</option>
                      <option value="PENANG">Penang</option>
                      <option value="KELANTAN">Kelantan</option>
                      <option value="TERENGGANU">Terengganu</option>
                      <option value="PAHANG">Pahang</option>
                      <option value="SELANGOR">Selangor</option>
                      <option value="MELAKA">Melaka</option>
                      <option value="NEGERI SEMBILAN">Negeri Sembilan</option>
                      <option value="JOHOR">Johor</option>
                      <option value="SABAH">Sabah</option>
                      <option value="SARAWAK">Sarawak</option>
                      <option value="WILAYAH PERSEKUTUAN">Wilayah Persekutuan</option>
					</select>
				</div>
			</div>
			<br> 
			<div class="containerForm" style="background-color: white">
			      <button type="submit" class="sub-btn" >Submit</button>
			      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancel-btn">Cancel</button>
			</div>
		</form>
	</div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>