<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'simpleconnect.php';
//include_once "wahala.php;";

$templike = 'melike';
$tempdislike = 'medislike';

 if( isset($_POST['chat']))
 {
   echo $_POST['chat'];
   $chat = htmlspecialchars($_POST['chat']);
   echo $chat;
   $usertempId  = $_SESSION["id"];
    $username   = $_SESSION["user"];
    $usergrpId  = $_SESSION["grpid"];
    $userroomId = $_SESSION["RoomID"];

  // taking values from submit button and inserting to the database
 $sql= "INSERT INTO `message` (`MessageId`, `userid`, `Message`, `Time`, `GRPID`)
        VALUES (NULL, '$usertempId', '$chat', CURRENT_TIMESTAMP, '$usergrpId')";

        if (mysqli_query($connection, $sql)) {
        echo "New record created successfully";
        } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connection);
        }
        header("location:simplechat.php");
        mysqli_close($connection);
 }

 // if (!empty($_POST)) {
 //   $connection = mysqli_connect("like");
 //   $statement = mysqli_prepare($connection, "INSERT INTO reactions ($usertempId, PageId) VALUES (?, ?,?,?)");
 //   mysqli_stmt_bind_param($statement, $_POST["IP"], $_GET["id"]);
 //   mysqli_stmt_execute($statement);
 //   exit;
 // }
 $data = $connection->get('reactions');
if (isset($_POST['like'])) {
    $post_id = $_POST['like'];
    $query = Array('melike'=>$connection->inc(1));
    $connection->where('id', $post_id);
    $connection->update('reactions', $query);
    $connection->insert('likes', Array('post_id'=>$post_id));
}
foreach ($posts as $post) {
    echo $post["post_text"] .'&nbsp;<button data-postid="'.$post['id'].'" data-likes="'.$post['like_count'].'" class="like">Like ('.$post['like_count'].')</button><hr />';
}

 ?>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <script type="text/javascript">
 $(".like").click(function(){
     let button = $(this)
     let post_id = $(button).data('postid')
 $.post("index.php",
 {
     'like' : post_id
 },
 function(data, status){
     $(button).html("Like (" + ($(button).data('likes')+1) + ")")
     $(button).data('likes', $(button).data('likes')+1)
 });
 });
 </script>
