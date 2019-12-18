<?php
 session_start();

 echo "Userid accessing this site is " . $_SESSION["user_id"] . ".<br>";
// If form submitted, insert values into the database.
if (isset($_POST['token'])){
	$connection = new mysqli("localhost", "admin", "monarchs", "cs518db");
	
				// Check connection
			if ($connection->connect_error) {
			    die("Connection failed: " . $connection->connect_error);
			} 

		                  // removes backslashes
			 $token = stripslashes($_REQUEST['token']);
		        //escapes special characters in a string
			 $token = mysqli_real_escape_string($connection,$token);

			 $token = $connection->real_escape_string($_POST["token"]);

		            
			$sql = "UPDATE tokentbl SET token ='$token' WHERE user_id ={$_SESSION['user_id']}";

			if ($connection->query($sql) === TRUE) {
			    echo "Record updated successfully";
				header("Location: updatepassword.php ");
			} else {
			    echo "Error updating record: " . $connection->error;
			    echo "<div class='form'>
					<h3>Username/password is incorrect.</h3>
					<br/>Click here to reset <a href='forgotPassword.php'>Login</a>

					</div>";
			}

			$connection->close();

   
      
    }
?>


<html>
	<body>
<div class="form">
<h1>Add token sent into your Email here </h1>
<form action="" method="post" name="login">
<input type="text" name="token" placeholder="Type your token " required />
<input name="submit" type="submit" value="submit token" />
</form>

</div>
   </body>
</html>


</body>
</html>

