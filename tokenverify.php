<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 session_start();

 // print_r($_SESSION);

 echo "User accessing this site is user with id " . $_SESSION["user_id"] . ".<br>";
// If form submitted, insert values into the database.
			if (isset($_POST['token'])){

				$connection = new mysqli("localhost", "admin", "monarchs", "cs518db");
                                if ($connection->connect_error) {
                                 die("Connection failed: " . $connection->connect_error);
                                } 
				
				$token = stripslashes($_REQUEST['token']);
				$token = mysqli_real_escape_string($connection,$token);

	
         // $query = "SELECT `user_id`, `token` FROM `tokentbl` WHERE user_id = '" . $_SESSION['user_id'] . "' ";

//         		 $sql ="SELECT `user_id`, `token` FROM `tokentbl` WHERE user_id ='{$_SESSION['user_id']}'";
				
			 $sql = "SELECT * FROM  tokentbl";
		         $result = $connection->query($sql);

	    		if ($result->num_rows > 0) {
        		echo " Information match ";
	  
            // Redirect user to index.php
	    		header("Location: updatepassword.php ");

         }else{
				echo "<div class='form'>
				<h3>Username/password is incorrect.</h3>
				<br/>Click here to <a href='forgotPassword.php'>Login</a></div>";
			}
    }

?>


<html>
	<body oncontextmenu="return false;">
<div class="form">
<h1>Add token sent into your Email here </h1>
<form action="" method="post" name="login">
<input type="text" name="token" placeholder="Type your token " required />
<input name="submit" type="submit" value="submit token" />
</form>

</div>
   </body>
</html>

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
