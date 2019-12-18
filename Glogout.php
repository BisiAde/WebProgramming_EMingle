<?php
session_start(); 
session_regenerate_id(true); 


// unset($_SESSION['access_token']);
// unset($_SESSION['email']);
// unset($_SESSION['picture']);

// Unset all of the session variables.
$_SESSION = array();

// unset cookies
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();

header("location:http://bisiade.cs518.cs.odu.edu/index.php");
exit;

 ?>
