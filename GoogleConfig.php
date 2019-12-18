<?php 
session_start();
require_once "GoogleApi/vendor/autoload.php";


$gclient = new Google_Client();
$gclient->setClientId("924710333800-7unin8g9om212vm17hbngsi8vl6bamq4.apps.googleusercontent.com");
$gclient->setClientSecret("ULRlRe0nnYbn6tQhnHbIg1up");
$gclient->setApplicationName("L518App");
$gclient->setRedirectUri( "http://bisiade.cs518.cs.odu.edu/Gcallback.php");
$gclient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile");

 ?>
