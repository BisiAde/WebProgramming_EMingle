<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

        // Start the session
        session_start();
        require './PHPMailer/PHPMailerAutoload.php';
        require 'credential.php';
                  if (isset($_POST["forgotPass"])) {
			 $connection = new mysqli("localhost", "admin", "monarchs", "cs518db");
			 if ($connection->connect_error) {
                        die("Connection failed: " . $connection->connect_error);
                       }
			  	$email = $connection->real_escape_string($_POST["email"]);

   		               $result = $connection->query("SELECT `user_id`, `email` FROM `User` WHERE `email` ='$email'");
			       $rows=mysqli_fetch_array($result);
                               $_SESSION['user_id'] = $rows['user_id'];
                               $_SESSION['email'] = $rows['email'];
			       $userid = $_SESSION['user_id'];
			  
			     if ($result->num_rows === 0) {

                              header("refresh:0.5;url= http://bisiade.cs518.cs.odu.edu/index.php"); // really should be a fully qualified URI
                              echo '<script type="text/javascript">alert("This email does not exist in our system.Please Enter Correct Details!");</script>';

        }else {
			  if ($result->num_rows > 0) {
			      $str = "0123456789qwertzuioplkjhgfdsayxcvbnm";
   			      $str = str_shuffle($str);
   			      $str = substr($str, 0, 10);  
			    
				  
//  			      $connection->query
// 				$sql= ("UPDATE tokentbl
//                                         JOIN User ON tokentbl.user_id = User.user_id 
//    			                SET tokentbl.token = '$str'
//                                         WHERE User.email='$email'");
				  
				  $sql= ("UPDATE `User`
   			                SET `token` = '$str'
                                        WHERE User.email='$email'");
				  
				if ($connection->query($sql) === TRUE) {
                                echo "Record updated successfully Close your Browser and follow the instruction sent to your email";
                                } else {
                                echo "Error updating record: " . $connection->error;
                                }  
				  
				  $mail = new PHPMailer;
				  $mail->isSMTP(); 
				  $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
  			          $mail->SMTPAuth = true;                               // Enable SMTP authentication
  				  $mail->Username = EMAIL;                             // SMTP username
   				  $mail->Password = PASS;                              // SMTP password
   				  $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
   				  $mail->Port = 587;                                    // TCP port to connect to
                               // $mail->SMTPDebug = 2;
				  $mail->setFrom(EMAIL, 'Administrator');
   				  $mail->addAddress($_POST['email']);                   //Add recipient
   					
   				  $mail->addReplyTo(EMAIL);
				  $mail->isHTML(true); 
				  $mail->Subject = 'Here is the subject';
   					$mail->Body    = "
   							            Hi,<br><br>

   				In order to reset your password, please click on the link below:<br>
   			        <a href=' http://BisiAde.cs518.cs.odu.edu/tokeyverify.php?email=$email&token=$str'>
                                   http://BisiAde.cs518.cs.odu.edu/tokeyverify.php?email=$email&token=$str</a><br><br>
				   
				      <a>Copy the code below, Click on the above link and provide the information reqiested </a> <br><br>
                                       <a> $str </a> <br><br>

   							            Kind Regards,<br>
   							            My Name
   							        ";
				  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                                if(!$mail->send()) {
					echo 'Message could not be sent.';
   					echo 'Mailer Error: ' . $mail->ErrorInfo;
				}else {
   					 echo 'Message has been sent';
   					}
			  }
		  }
	
	 }
?>
<html>
 <head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
	<body oncontextmenu="return false;">
		  <div class="container" style="margin-top: 100px;">
             <div class="row justify-content-center">
               <div class="col-md-6 col-md-offset-3" align="center">

                     <h2>We will  send you a reset-link when you insert your Email </h2>
				    <form action="forgotPassword.php" method="post">
					<input type="text" name="email" placeholder="Email"><br>
					<input type="submit" name="forgotPass" value="Request Password">
				    </form>
		    </div>
        </div>
    </div>
		
<script type="text/javascript">
	document.onkeydown = function(e) {
  if(event.keyCode == 123) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
     return false;
  }
}
</script>
	</body>
</html>
