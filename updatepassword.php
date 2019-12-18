<?php
        // Start the session
        session_start();
        // print_r($_SESSION)

        $confirmpassword= " ";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

	   if (isset($_POST["submitPassword"])) {

		$connection = new mysqli("localhost", "admin", "monarchs", "cs518db");

		 $password = $connection->real_escape_string($_POST["password"]);



		 $confirmpassword = $connection->real_escape_string($_POST["passwordConfirm"]);


        if($password != $confirmpassword){
        	// if ($_POST['password']!= $_POST['confirmpassword']){
			echo ("Password does not match");

		  } else if (preg_match('/[^A-Za-z0-9]/', $password))  {
                  echo("invalid strings present");
		 }

		  else{

				$data = $connection->query("UPDATE `User` SET `password` = '$password' WHERE user_id = '" . $_SESSION['user_id'] . "'  ");

				printf("Affected rows (UPDATE): %d\n", $connection->affected_rows);

		        // $_SESSION['mydata'] = $data->fetch_assoc(); // storing sql query result in session

		        // $rows=mysqli_fetch_array($data);

				if ($data > 0) {

					 echo "success";
					 header("Location: index.php ");

				} else {
					echo "Please check your inputs!";
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
	<body>
		<div class="container" style="margin-top: 100px;">
        <div class="row justify-content-center">
            <div class="col-md-6 col-md-offset-3" align="center">

         <h1>Insert Password  </h1>
		<form action="" method="post">
			<input type="password" name="password" placeholder="Type password" required""><br><br>

			<input type="password" name="passwordConfirm" placeholder="confirm password" required""><br><br>
			<input type="submit" name="submitPassword" value="Submit Password">
		</form>

		    </div>
        </div>
    </div>
	</body>
</html>


