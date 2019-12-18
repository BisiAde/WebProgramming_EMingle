<?php
 session_start();

//  echo "Userid accessing this site is " . $_SESSION["user_id"] . ".<br>";
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

// 		        $sql = "UPDATE tokentbl SET token ='$token' WHERE user_id ={$_SESSION['user_id']}";    
// 	                $result = $connection->query("SELECT token FROM tokentbl WHERE user_id ='".$_SESSION['user_id']."' ");
	                
	                $result = mysqli_query($connection, "SELECT `token` FROM `User` WHERE user_id = '" . $_SESSION['user_id'] . "'  " );
			$row = $result->fetch_assoc();  
	                $toks= $row['token'];
// 	                echo $toks;
	                
                        $validatecode = $_POST['token'];

//                        echo $validatecode;
            
			if ($validatecode !== $toks) {

			 header("refresh:0.5;url=tokeyverify.php"); // really should be a fully qualified URI
             echo '<script type="text/javascript">alert("You typed in the wrong code, Please insert the correct details!");</script>';
			} else {


			    if ($validatecode == $toks) {

			    echo "Record updated successfully";
			    header("Location: updatepassword.php "); 

			    }
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

