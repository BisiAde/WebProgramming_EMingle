<?php
require_once 'PHPGangsta/GoogleAuthenticator.php';
$ga = new PHPGangsta_GoogleAuthenticator();
$secret = $ga->createSecret(); //creating the secret
echo $secret.'<br />';

$qr = $ga ->getQRCodeGoogleUrl('Ievent',$secret);
echo '<img src="'.$qr.'" /><br/>';

// getting the code using the secret
$myCode = $ga->getCode($secret);
$result = $ga->verifyCode($secret, $myCode, 3);
if ($result) {
   echo 'Verified';
} else {
   echo 'Not verified';
}
echo $result;
 ?>
