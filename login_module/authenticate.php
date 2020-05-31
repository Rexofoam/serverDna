<!DOCTYPE html>
<html>
<body>

<head>
    <title>Authenticate Account</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" href="css/form.css" />
<!--===============================================================================================-->
</head>
<body>
    <div class="limiter">
        <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
            <div class="wrap-login100">
                <form class="login100-form validate-form" action="authenticate_account.php" method="post">

                    <span class="login100-form-title p-b-34 p-t-27">
                        Authenticate Account
                    </span>

                    <p style="text-align: center; color:white" id="checkPsw">
                        <?php 
                            session_start();
                            if(isset($_SESSION["fallback_msg"])){
                                echo $_SESSION["fallback_msg"];
                                $_SESSION["fallback_msg"] = "";
                            }
                            session_destroy();
                        ?>
                    <p>

                    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <input class="input100" type="password" name="psw1" placeholder="New Password" required>
                        <span class="focus-input100" data-placeholder="&#xf191;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <input class="input100" type="password" name="psw2" placeholder="Re-enter Password" required>
                        <span class="focus-input100" data-placeholder="&#xf191;"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" id="btnChk">
                            Authenticate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

    

</body>
</html>