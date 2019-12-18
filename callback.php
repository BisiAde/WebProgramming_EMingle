<?php
require "init.php";
$data = fetchData();
if (!isset($_SESSION['user'])) {
    header("location: http://bisiade.cs518.cs.odu.edu/index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signed In</title>
</head>
<body style="margin-top: 200px; text-align: center;">
    <div>
        <?php var_dump($_SESSION['payload']) ?>
        <a href="http://bisiade.cs518.cs.odu.edu">Log Out</a>
    </div>
</body>
</html>
