<?php 
 session_start();
ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);
 include('services.php');

 $_POST['email'] = $_SESSION['email'];
  
$conn = new mysqli("localhost", "admin", "monarchs", "cs518db");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
  if(!isset($_SESSION['access_token']))
 { 
 	header("http://bisiade.cs518.cs.odu.edu/Glogout.php/index.php");  // if there is no acccess token set then redirect to login page
 	exit();
   
 }

$result = mysqli_query($conn, "SELECT `password` FROM `User` WHERE email = '" . $_SESSION['email'] . "'  " );
 $row = $result->fetch_assoc();  
 $pass= $row['password'];
// echo $test;

 if ($result->num_rows === 0) {
  
  $VarEmail = $_SESSION['email'];
  $VarName = $_SESSION['givenName'];
  $VarToken = $_SESSION['id'] ;
  
  echo $VarEmail ;
  echo $VarName ;
  echo  $VarToken ;
  
//   $data = $conn->query("INSERT INTO `User` (`fname`, `email`,`token`,`password`) VALUES ('$VarName', '$VarEmail', $VarToken, $VarToken)" );
  
  if($stmt = $conn->prepare("INSERT INTO `User` (`fname`, `email`,`token`,`password`) values (?,?,?,?)"))
  {
   $stmt->bind_param('ssss', $VarName, $VarEmail, $VarToken, $VarToken);
            $stmt->execute();
        $stmt->close();
  }else {
              echo ("Failed");
              $conn->close();
             }
//  header("http://bisiade.cs518.cs.odu.edu/Gwelcome.php"); 
   header("refresh:0.5;url= http://bisiade.cs518.cs.odu.edu/Gwelcome.php"); 
   echo '<script type="text/javascript">alert("email does not exist in our system. We will add you. Click the login button Again!");</script>';
 } 
  
       

$conn->close();
 ?>

<!DOCTYPE html>
<html lang = "en">
<head>
      <meta charset = "utf-8">
      <meta name = "viewport">
           <link rel="stylesheet" type="text/css" href="style.css">
           <link href="https://fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">
           <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

     <title>Login with google </title>    	
</head>
 
<body oncontextmenu="return false;">
 <div class="container" style = "margin-top: 100px"
      <h1> Welcome <?php echo $_SESSION['email']; ?></h1>
      <br>
      <br>

      <div class="row">
          <div class ="col-md-3">
          	<img style="width: 20%;" src="<?php echo $_SESSION['picture']; ?>"
          </div>
          <div class ="col-md-6">
          <table class="table table-hover table-bordered">
          <tbody>
          <tr>
<!--             <td>ID</td> -->
<!--             <td><?php echo $_SESSION['id'] ?></td> -->
          </tr>
          <tr>
            <td>First Name  :</td>
            <td><?php echo $_SESSION['givenName'] ?></td>
          </tr>
          <tr>
            <td>Last Name</td>
            <td><?php echo $_SESSION['familyName'] ?></td>
          </tr>
          <tr>
            <td>Email</td>
            <td><?php echo $_SESSION['email'] ?></td>
          </tr>
          
        </tbody>

              
             
              <input type="hidden" name="email" type="email" placeholder="Email Address">

         </table>
     
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
                                             
                                         
                                           <?php echo ($_POST['email']);?>

            				         <div class="pure-control-group">
            				          <button type="submit" class="pure-button pure-button-primary">Login
               
            				       </div>
<!--                                <h3> Do a one time Registration with a Valid email address to use the Google login feature  </h3> -->

            				    </fieldset>
            				</form>
                
                    
                      
            </div>
       </script>

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

  			document.getElementById('loginForm').setAttribute('action', 'sciMein.php' + aTag.search);
  		}

  	</script>
</body>
</html>
