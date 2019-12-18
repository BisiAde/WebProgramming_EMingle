<?php
session_start();
session_unset();
session_destroy();
unset($_SESSION['access_token']);
unset($_SESSION['state']);
unset($_SESSION['oauth_token'] );
unset($_SESSION['oauth_token_secret']); 

if(isset($_SESSION['twitter_access_token'])){
    unset($_SESSION['twitter_access_token']);
}

foreach ($_COOKIE as $key => $value) {
    unset($value);
    setcookie($key, '', time() - 3600);
}
 
// header('Location: index.php');
header("Location:https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://BisiAde.cs518.cs.odu.edu/index.php");

exit;


?>
