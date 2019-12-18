<?php
session_regenerate_id(true); 
      session_start();
    include('services.php');

  require "init.php";
  require_once "GoogleConfig.php";
  require_once "fb-config.php"; 

require 'Twconfig.php';
require 'twitter_login_php/twitter-login-php/autoload.php';

  // use our twitter helper
	use Abraham\TwitterOAuth\TwitterOAuth;
// dropping twitter codes

if ( isset( $_SESSION['twitter_access_token'] ) && $_SESSION['twitter_access_token'] ) { 
		$isLoggedIn = true;	
} elseif ( isset( $_GET['oauth_verifier'] ) && isset( $_GET['oauth_token'] )
	&& isset( $_SESSION['oauth_token'] ) && $_GET['oauth_token'] == $_SESSION['oauth_token'] ) { 

  $connection = new TwitterOAuth( CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret'] );
		
		// get an access token
		$access_token = $connection->oauth( "oauth/access_token", array( "oauth_verifier" => $_GET['oauth_verifier'] ) );

		// save access token to the session
		$_SESSION['twitter_access_token'] = $access_token;

		// user is logged in
		$isLoggedIn = true;
	}else { 
// 		$connection = new TwitterOAuth( CONSUMER_KEY, CONSUMER_SECRET );
// 		$request_token = $connection->oauth( 'oauth/request_token', array( 'oauth_callback' => OAUTH_CALLBACK ) );
// 		$_SESSION['oauth_token'] = $request_token['oauth_token'];
// 		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
// 		$isLoggedIn = false;
	}


// End of Twitter codes

   $loginurl = $gclient->createAuthUrl();

   $redirectURL = "http://bisiade.cs518.cs.odu.edu/fb-callback.php";
   $permissions = ['email'];
   $loginURL = $helper->getLoginUrl($redirectURL, $permissions);
  



  //$this will redirect user to github authorization page
//    goToAuthUrl();
//   if(isset($_SESSION['user'])) {
 
//     header("location:http://bisiade.cs518.cs.odu.edu/callback.php");
//   }

  if( isset($_SESSION['authenticationFlag']) === true )
  {
     header('Location: main.php?channel=general');
//      header('Location: indexi.php');
    exit;
  }
   gitLogin();

  //credit: https://gist.github.com/asika32764/b204ff4799d577fd4eef
  function gitLogin()
  {
    define('OAUTH2_CLIENT_ID', 'cc26ffab61ce609a0da9');
    define('OAUTH2_CLIENT_SECRET', '618ed9100827f90c581526bc103897d68da0f64a');

    $authorizeURL = 'https://github.com/login/oauth/authorize';
    $tokenURL     = 'https://github.com/login/oauth/access_token';
    $apiURLBase   = 'https://api.github.com/';


    // Start the login process by sending the user to Github's authorization page
    if(get('action') == 'login') 
    {
        // Generate a random hash and store in the session for security
        $_SESSION['state'] = hash('sha256', microtime(TRUE) . rand() . $_SERVER['REMOTE_ADDR']);
        unset($_SESSION['access_token']);
        $params = array(
            'client_id' => OAUTH2_CLIENT_ID,
            'redirect_uri' => 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'],
            'scope' => 'user',
            'state' => $_SESSION['state']
        );
        // Redirect the user to Github's authorization page
        header('Location: ' . $authorizeURL . '?' . http_build_query($params));
        die();
    }

    // When Github redirects the user back here, there will be a "code" and "state" parameter in the query string
    if (get('code')) 
    {
        // Verify the state matches our stored state
        if (!get('state') || $_SESSION['state'] != get('state')) {
            header('Location: ' . $_SERVER['PHP_SELF']);
            die();
        }
        // Exchange the auth code for a token
        $token                    = apiRequest($tokenURL, array(
            'client_id' => OAUTH2_CLIENT_ID,
            'client_secret' => OAUTH2_CLIENT_SECRET,
            'redirect_uri' => 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'],
            'state' => $_SESSION['state'],
            'code' => get('code')
        ));
        $_SESSION['access_token'] = $token->access_token;
        header('Location: ' . $_SERVER['PHP_SELF']);
    }
  }


  function apiRequest($url, $post = FALSE, $headers = array())
  {
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      if ($post)
          curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
      $headers[] = 'Accept: application/json';
      if (session('access_token'))
          $headers[] = 'Authorization: Bearer ' . session('access_token');
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      $response = curl_exec($ch);
      return json_decode($response);
  }

  function get($key, $default = NULL)
  {
      return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
  }

  function session($key, $default = NULL)
  {
      return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
	 
  }

// login prama



 if( isset($_POST['email']) and isset($_POST['password']) ) {

   $email=($_POST['email']);
   $password=($_POST['password']);

  // " SELECT `email`,`password`,`fname`,`user_id` FROM `user` WHERE `email`='mater@rsprings.gov' AND `password`='@mater'"

   $sql = " SELECT `email`,`password`
            FROM `User`
            WHERE `email`='$email'
            AND `password`='$password' ";

   $result=mysqli_query( $conn, $sql) or


 die("Could not execute query: " .mysqli_error($conn));
 $row = mysqli_fetch_assoc($result);

 if(!$row) {
      header("Location: index.php");
    }
    else {
          session_start();
           $_SESSION['email']=$email;
           $_SESSION['id'] = $row['userid']; // grabbing / creating and storing user session.
          //$_SESSION['grpid'] = $row['$GRPID'];

      header('location: indexi.php');

    }
 }

// End  
?>


<html>

<head>
  <meta name="google-signin-client_id" content="924710333800-7unin8g9om212vm17hbngsi8vl6bamq4.apps.googleusercontent.com">
  <link rel="stylesheet" type="text/css" href="style.css">
 <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <link rel="search" type="application/opensearchdescription+xml" href="http://localhost/Ievent/opensearch.xml" title="MySite Search" /

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
  
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <script src="https://apis.google.com/js/platform.js" async defer></script>

<body oncontextmenu="return false;">
  <div style="background-color:black">
        <h3>div element black</h3>
        <p>This area is black</p>
        </div>

  <div style="text-align:center; font-size: 40px; color: #3B0029;">
    <strong></strong>
  </div>

  <hr class="style13">
  <!--
  See for form validation:
  https://www.w3schools.com/PhP/showphp.asp?filename=demo_form_validation_complete
  -->

  <table style="width: 60%; cellpadding: 10px; margin: 0 auto;">
    <tr>

      <td align="center">
        <div style="padding: 10px 0px 0px 10px; width:80%; height: 20%;">
        <h3> Login </h3>

        <?php
          if( isset($_SESSION['index.php.msg']) )
          {
            echo '<strong><p style="color: red">' . $_SESSION['index.php.msg'] . '</p></strong>';
          }
        ?>


        <form action="index.php" method="post" class="pure-form pure-form-aligned" >
<div class="container3" style="background-color:black">
            <fieldset>
                <div class="pure-control-group">
                    <input name="email" id="email" type="email" placeholder="Email Address">
                </div>

                <div class="pure-control-group">
                    <input id="loginPass" name="password" type="password" placeholder="Password">
          <p><a href="forgotPassword.php">forgotPassword</a></p>
                </div>

                <div class="pure-control-group">
                  <button type="submit" class="pure-button pure-button-primary">Login
                                         <i class="fas fa-sign-in-alt"></i>
                </div>
                   <button type="button" class = "btn btn-danger" style = "width:150px; background-color:silver;
                   margin-left: -10px; "onclick="window.location = '<?php echo $loginurl;?>'">Sign in with GOOGLE</button>
               </div>
 </div>
            </fieldset>
        </form>
          <!-- <a href = "login.php"> Sign in with Github</a> -->
<!--           <p><a href="twitter_login_php/index.php">Sign in with Twitter</a></p>  -->
		
<!--           <?php

          if (session('access_token'))
          {
              echo '<h3>Git: Logged In</h3>';
          }
          else
          {
              echo '<h3>Git: Not logged in</h3>';
              echo '<p><a href="?action=login">Log In</a></p>';
          }
        ?> -->
      </div>
      </td>

      <td align="center">
        <div style="padding: 10px 0px 0px 10px;width: 80%; height: 20%;">
        <h3> Register </h3>

        <?php
          if( isset($_SESSION['register.php.msg']) )
          {
            if( $_SESSION['register.php.msg'] == 'go' )
            {
              unset( $_SESSION['register.php.msg'] );
              echo '<strong><p style="color: green">Registration successful, please login.</p></strong>';
            }
            else
            {
              echo '<strong><p style="color: red">' . $_SESSION['register.php.msg'] . '</p></strong>';
            }
          }
        ?>

        <form class="pure-form" action="register.php" method="post">
<div class="container2" style="background-color:black">
          <fieldset>
                  <input type="text" placeholder="First name" name="First-name">
                  
          </fieldset>
	   <fieldset>
		<input type="text" placeholder="Last name" name="Last-name">   
	   </fieldset>

            <fieldset>
                <input type="password" placeholder="Password" name="Password">
                
            </fieldset>
		<input type="password" placeholder="Re-type password" name="Re-Password">
	    <fieldset>
	    </fieldset>

            <fieldset>
              <div class="g-recaptcha" data-sitekey="6LcXVqMUAAAAAGAKRvdw-QRehIOQY9A-Zs-87UC0"></div>
              <input type="email" placeholder="Email" name="Email">
              <button type="submit" class="pure-button pure-button-primary">Register
           <i class="fas fa-user-plus"></i> 
           </button>
</div>
          </fieldset>

          <fieldset>
            
          <!-- <input type="submit" value="Log In" class="btn btn-primary"> -->
          <input type="button" onclick="window.location = '<?php echo $loginURL ?>';" value="Log In With Facebook" class="btn btn-primary " style="background-color:#0000ff;color:#D0F18F">

          </fieldset>

        </form>

      </div>
      </td>

    </tr>
  </table>


<!--  <div id='infoArea' style="width: 50%; height: 50%;"> -->
    <?php
      $msgExtraParams = array(
        'max' => 3,
        'role_type' =>
        'DEFAULT',
        'state' => 'ACTIVE',
        'page_size' => 3,
        'page' => 1
      );

//      echo '<h3># general</h3>';
//      getMessages(1, 0, -1, $msgExtraParams);
//      echo '<h3># random</h3>';
//      getMessages(2, 0, -1, $msgExtraParams);
		 
		  $_SESSION['email'] = $_POST['email'];
     ?>
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
  
	  
	  
//     main();

//     function main()
//     {
//       var aTag = document.createElement("a");
//       aTag.href = window.location.href;

//       if( aTag.search.length === 0 )
//       {
//         aTag.search = '?channel=general';
//       }

//       document.getElementById('loginForm').setAttribute('action', 'indexi.php');
//     }

  </script>
<!-- adding google maps -->
  <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyAEiM204_FX_p4HIWHy66Nac0rVZ2N4aVI"></script>
  <script>
  if("geolocation" in navigator) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var latlng = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
      var myOptions = {
        zoom: 8,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.TERRAIN,
        disableDefaultUI: true
      }
      var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    });
  } else {
    var para = document.createElement('p');
    para.textContent = 'Argh, no geolocation!';
    document.body.appendChild(para);
  }
	  
  </script>
  <style>
    #map_canvas {
      width: 600px;
      height: 600px;
      margin-left: auto;
      margin-right: auto;
    }
    
 body {    
   
   background-image:url("./images/bg.jpg") ;
  
   }
      .container2 {
  padding: 20px;
}

  .container3 {
  padding: 20px;
}
  </style>
</head>
<body>
  <h1></h1>
  <div id="map_canvas"></div>

</body>
</html>
