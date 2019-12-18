<?php 
require_once "Twconfig.php";
 unset($_SESSION['access_token']);
 session_destroy();
 header("location:index.php"); 
 
 exit();


 ?>
