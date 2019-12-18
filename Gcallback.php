<?php 
require_once "GoogleConfig.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['access_token']))
		$gclient->setAccessToken($_SESSION['access_token']);
	else if (isset($_GET['code'])) {
		$token = $gclient->fetchAccessTokenWithAuthCode($_GET['code']);
		$_SESSION['access_token'] = $token;
	} else {
		header('Location: index.php');
		exit();
	}

	$oAuth = new Google_Service_Oauth2($gclient);
	$userData = $oAuth->userinfo_v2_me->get();

 $oAuth = new Google_Service_Oauth2($gclient);
 $userdata = $oAuth->userinfo_v2_me->get();

    $_SESSION['id'] = $userData['id'];
	$_SESSION['email'] = $userData['email'];
	$_SESSION['gender'] = $userData['gender'];
	$_SESSION['picture'] = $userData['picture'];
	$_SESSION['familyName'] = $userData['familyName'];
	$_SESSION['givenName'] = $userData['givenName'];


// print_r($_SESSION);
 print_r($_SESSION);

header("location:Gwelcome.php");
exit();

 ?>
