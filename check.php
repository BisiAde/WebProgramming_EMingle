<?php
session_start();
include('services.php');
// print_r($_SESSION);

$conn = new mysqli("localhost", "admin", "monarchs", "cs518db");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

require "Authenticator.php";
if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("location: index.php");
    die();
}
$Authenticator = new Authenticator();




$checkResult = $Authenticator->verifyCode($_SESSION['auth_secret'], $_POST['code'], 2);    // 2 = 2*30sec clock tolerance

$_SESSION['Derivedcode'] = $_POST['code'];

 $code = $_SESSION['Derivedcode'];

//  echo "This is my echo result " . $code;

$sql = " UPDATE `User` SET `code`='$code'
         WHERE `email` = '" . $_SESSION['email'] . "' ";

         if ($conn->query($sql) === TRUE) {
              echo "Record updated successfully";
          } else {
              echo "Error updating record: " . $conn->error;
          }


if (!$checkResult) {
    $_SESSION['failed'] = true;
    header("location: index.php");
    die();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Authentication Successful</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <link rel='shortcut icon' href='/favicon.ico'  />
    <style>
        body,html {
            height: 100%;
        }


        .bg {
            /* The image used */
            background-image;
            /* Full height */
            height: 100%;
            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;

            background-size: cover;
        }
    </style>
</head>
<body  class="bg">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3"  style="background: white; padding: 20px; box-shadow: 10px 10px 5px #888888; margin-top: 100px;">
                <hr>
                    <div style="text-align: center;">
                           <h1>Authentication Successful</h1>

                    </div>
                    <form id='loginForm' class="pure-form pure-form-aligned" action="" method="post">
            				    <fieldset>
            				        <div class="pure-control-group">
            				            <input name="code" type="code" placeholder="Retype scanned code ">
            				        </div>

            				        <div class="pure-control-group">
            				            <input id="loginPass" name="password" type="password" placeholder="Type your user Password">
            				        </div>

            				        <div class="pure-control-group">
            				          <button type="submit" class="pure-button pure-button-primary">Login
                                                     <i class="fas fa-sign-in-alt"></i>
            				        </div>

            				    </fieldset>
            				</form>
                <hr>
                    <a target="_blank" href="https://www.Ievent.com"><p style="text-align: center;"> </a>
            </div>
        </div>
    </div>

    <script type="text/javascript">
  		main();

  		function main()
  		{
  			var aTag = document.createElement("a");
  			aTag.href = window.location.href;

  			if( aTag.search.length === 0 )
  			{
  				aTag.search = '?channel=general';
  			}

  			document.getElementById('loginForm').setAttribute('action', 'main.php' + aTag.search);
  		}

  	</script>
</body>
</html>
