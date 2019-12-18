<?php
	// using sessions to store token info
	session_start();
    print_r($_SESSION);

$conn = new mysqli("localhost", "admin", "monarchs", "cs518db");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }




	// require config and twitter helper
	require 'config.php';
	require './twitter-login-php/autoload.php';

	// use our twitter helper
	use Abraham\TwitterOAuth\TwitterOAuth;

	if ( isset( $_SESSION['twitter_access_token'] ) && $_SESSION['twitter_access_token'] ) { // we have an access token
		$isLoggedIn = true;	
	} elseif ( isset( $_GET['oauth_verifier'] ) && isset( $_GET['oauth_token'] ) && isset( $_SESSION['oauth_token'] ) && $_GET['oauth_token'] == $_SESSION['oauth_token'] ) { // coming from twitter callback url
		// setup connection to twitter with request token
		$connection = new TwitterOAuth( CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret'] );
		
		// get an access token
		$access_token = $connection->oauth( "oauth/access_token", array( "oauth_verifier" => $_GET['oauth_verifier'] ) );

		// save access token to the session
		$_SESSION['twitter_access_token'] = $access_token;

		// user is logged in
		$isLoggedIn = true;
	} else { // not authorized with our app, show login button
		// connect to twitter with our app creds
		$connection = new TwitterOAuth( CONSUMER_KEY, CONSUMER_SECRET );

		// get a request token from twitter
		$request_token = $connection->oauth( 'oauth/request_token', array( 'oauth_callback' => OAUTH_CALLBACK ) );

		// save twitter token info to the session
		$_SESSION['oauth_token'] = $request_token['oauth_token'];
		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

		// user is logged in
		$isLoggedIn = false;
	}

	if ( $isLoggedIn ) { // logged in
		// get token info from session
		$oauthToken = $_SESSION['twitter_access_token']['oauth_token'];
		$oauthTokenSecret = $_SESSION['twitter_access_token']['oauth_token_secret'];

		// setup connection
		$connection = new TwitterOAuth( CONSUMER_KEY, CONSUMER_SECRET, $oauthToken, $oauthTokenSecret );

		// user twitter connection to get user info
		$user = $connection->get( "account/verify_credentials", ['include_email' => 'true'] );

		if ( property_exists( $user, 'errors' ) ) { // errors, clear session so user has to re-authorize with our app
	    	$_SESSION = array();
	    	header( 'Refresh:0' );
	    } else { // display user info in browser
	    	?>
	    	<img src="<?php echo $user->profile_image_url; ?>" />
	    	<br />
	    	<b>User:</b> <?php echo $user->name; ?>
	    	<br />
	    	<b>Location:</b> <?php echo $user->location; ?>
	    	<br />
	    	<b>Twitter Handle:</b> <?php echo $user->screen_name; ?>
	    	<br />
	    	<b>User Created:</b> <?php echo $user->created_at; ?>
	    	<br />
	    	<b>User Description:</b> <?php echo $user->id; ?>
	    	<hr />
	    	<b>User Descriptiveemail:</b> <?php echo $user->email; ?>
	    	<br />
                <b>User UserID:</b> <?php echo $user->id; ?>
	    	<br />


	    	<!-- <h3>User Info</h3> -->
	    	<textarea style="height:400px;width:100%"><?php echo print_r( $user, true ); ?></textarea>
	    	<?php
	    }
	} else {  // not logged in, get and display the login with twitter link
		$url = $connection->url( 'oauth/authorize', array( 'oauth_token' => $request_token['oauth_token'] ) );
		?>
		<a href="<?php echo $url; ?>">Login With Twitter</a>
		<?php
	}

?>

<!DOCTYPE html>
	<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">
   <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <link rel="search" type="application/opensearchdescription+xml" href="http://localhost/Ievent/opensearch.xml" title="MySite Search" /

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	</head>
	<body oncontextmenu="return false;">

	 <div>
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

  			document.getElementById('loginForm').setAttribute('action', 'sciMein.php' + aTag.search);
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
	
