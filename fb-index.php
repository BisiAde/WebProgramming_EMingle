<?php
	session_start();
	include('services.php');

	if (!isset($_SESSION['access_token'])) {
		header('Location:http://bisiade.cs518.cs.odu.edu/fb-login.php');
		exit();
	}
    
 
    // print_r($_SESSION);

    echo $_SESSION['userData']['email'] ;
    $_POST['email'] = $_SESSION['userData']['email'] ;
  
    $conn = new mysqli("localhost", "admin", "monarchs", "cs518db");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    

    if ($stmt = $conn->prepare(" SELECT `password` FROM `User` WHERE email = ? LIMIT 1  ") ){
		$stmt->bind_param('s', $_SESSION['userData']['email']);
		$stmt->execute();
		   
		$pass = $stmt->get_result()->fetch_object()->password;
		
		} else {
			echo 'Email or password not found in our system';
		}



$conn->close();


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Profile</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">
</head>
<body oncontextmenu="return false;">
	<div class="container" style="margin-top: 100px">
		<div class="row justify-content-center">
			<div class="col-md-3">
				<img src="<?php echo $_SESSION['userData']['picture']['url'] ?>">
			</div>

			<div class="col-md-9">
				<table class="table table-hover table-bordered">
					<tbody>
						<tr>
							<td>ID</td>
							<td><?php echo $_SESSION['userData']['id'] ?></td>
						</tr>
						<tr>
							<td>First Name</td>
							<td><?php echo $_SESSION['userData']['first_name'] ?></td>
						</tr>
						<tr>
							<td>Last Name</td>
							<td><?php echo $_SESSION['userData']['last_name'] ?></td>
						</tr>
						<tr>
							<td>Email</td>
							<td><?php echo $_SESSION['userData']['email'] ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>



         </table>
     </div>
     <div class="col-md-3">
     <a href="Glogout.php"><button type="button" class="btn btn-danger" style="width:150px; background-color:silver; margin-left:-10px;">LOG OUT</button></a>
     </div>
 </div>

 </div>
                    <form id='loginForm' class="pure-form pure-form-aligned" action="" method="post">
            				 <fieldset>
            				        <div class="pure-control-group">
            				           <!-- <input type="hidden" name="email" type="email" placeholder="Email Address"> -->

            				   <input type="hidden" name="email" id="email" value="<?php print_r ($_POST['email']) ;?>" />

            				        </div>


                                <div class="pure-control-group">

                                 <!-- <input type="hidden" id="loginPass" name="password" type="password" > -->

                  <input type="hidden" name="password" id="loginPass" type="password" value="<?php echo $pass ;?>" />
            				    </div>
                                             
                                          
            				         <div class="pure-control-group">
            				          <button type="submit" class="pure-button pure-button-primary">Login
                                                     <!-- <i class="fas fa-sign-in-alt"></i> -->
            				          </div>

            				    </fieldset>
            				</form>
                
                    
                      
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
