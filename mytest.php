<?php
        // Start the session
        session_start();
        require 'PHPMailerAutoload.php';
        require 'credential.php';
	if (isset($_POST["forgotPass"])) {
		$connection = new mysqli("localhost", "admin", "monarchs", "cs518db");
    if ($connection->connect_error) {
                 die("Connection failed: " . $connection->connect_error);
                 }
		$email = $connection->real_escape_string($_POST["email"]);
		$result = $connection->query("SELECT user_id, email FROM User WHERE email ='$email'");
        // $_SESSION['mydata'] = $data->fetch_assoc(); // storing sql query result in session
        $rows=mysqli_fetch_array($result);
        $_SESSION['user_id'] = $rows['user_id'];
        $_SESSION['email'] = $rows['email'];
		if ($result->num_rows > 0) {
			$str = "0123456789qwertzuioplkjhgfdsayxcvbnm";
			$str = str_shuffle($str);
			$str = substr($str, 0, 10);
			// $url = "http://localhost/members/resetPassword.php?token=$str&email=$email";
			//mail($email, "Reset password", "To reset your password, please visit this: $url", "From: myanotheremail@domain.com\r\n");
			$connection->query("UPDATE tokentbl
                             JOIN User ON tokentbl.user_id = User.user_id
			     SET tokentbl.token = '$str'
                             WHERE User.email='$email'");
					$mail = new PHPMailer;
					// $mail->SMTPDebug = 4;                               // Enable verbose debug output
					$mail->isSMTP();                                      // Set mailer to use SMTP
					$mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
					$mail->SMTPAuth = true;                               // Enable SMTP authentication
					$mail->Username = EMAIL;                             // SMTP username
					$mail->Password = PASS;                              // SMTP password
					$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
					$mail->Port = 587;                                    // TCP port to connect to
          // $mail->SMTPDebug = 2;
					$mail->setFrom(EMAIL, 'Administrator');
					$mail->addAddress($_POST['email']);                   //Add recipient
					// $mail->addAddress('folufola@gmail.com');               // Name is optional
					$mail->addReplyTo(EMAIL);
					// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
					// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
					$mail->isHTML(true);                                  // Set email format to HTML
					$mail->Subject = 'Here is the subject';
					$mail->Body    = "
							            Hi,<br><br>
				In order to reset your password, please click on the link below:<br>
			<a href=' http://BisiAde.cs518.cs.odu.edu/tokenverify.php?email=$email&token=$str'>
                         http://BisiAde.cs518.cs.odu.edu/tokenverify.php?email=$email&token=$str</a><br><br>
							            Kind Regards,<br>
							            My Name
							        ";
					$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
					if(!$mail->send()) {
					    echo 'Message could not be sent.';
					    echo 'Mailer Error: ' . $mail->ErrorInfo;
					} else {
					 echo 'Message has been sent';
					}


    	}
		}
?>
