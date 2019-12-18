
<?php

 //session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'simpleconnect.php';
include 'mySqlFunctions.php';
//include 'wahala.php';
$usertempId = $_SESSION['id'];
// $usergrpId  =$_SESSION['grpid']
 ?>

<!DOCTYPE html>
<html>
<body>
<?php

// Echo session variables that were set on previous page
echo "welcome your userid is  " . $_SESSION["id"] . ".<br>";
echo "with username " . $_SESSION["user"] . ".<br>";
echo "A member of Group " . $_SESSION["grpid"] . ".<br>";
echo "You are in a room Named :" . $_SESSION["RoomName"]. ".<br>";
echo "with a RoomID           :" . $_SESSION["RoomID"]. ".<br>";
echo "group category          :" . $_SESSION["gcat"]. ".<br>";
//print_r($_SESSION);
?>
<html lang="en">
<head>

  <title>I-Event</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 1500px}

    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }

    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }

    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;}
    }
  </style>
</head>
<body>
  <a href="logout.php">Logout</a>


<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <h4>Chat Room</h4>
      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="?id=1">Home</a></li>
        <li><a href="?id=2">Room1</a></li>
        <li><a href="?id=3">Room2</a></li>
        <li><a href="?id=4">Room3</a></li>
        <a href="/goody/goodfiles/profile4.php" class="btn btn-info" role="button">My Profile</a>
        <a href="logout.php" class="btn btn-danger" role="button">Logout</a>
      </ul><br>
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search Blog..">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
    </div>

    <div class="col-sm-6">
             <h4><small>RECENT POSTS</small></h4>
             <hr>
              <h2>I Love Food</h2>
              <h4><small>RECENT POSTS</small></h4>
             <hr>
    <div class = "messageContainer">
    <div id = "allMessages">
          <?php
           $messages = getAllMessages($_GET["id"]);
           echo $messages;
           ?>
        </div>
        <hr>
      </div>
      <h4>chat:</h4>

      <form action="post.php" method="post" >
          <textarea class="form-control" name = "chat" rows="3" cols="40" required></textarea>
        <button type="submit" class="btn btn-success">submit</button>
        <form name="ratings">
            <input type="button" name="btnLike" value="Like">
            <input type="button" name="btnDislike" value="Dislike">
        </form>
         <!-- creating the like and the dislike button -->
         <html>
      <head>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <style>
      .fa {
          font-size: 20px;
          cursor: pointer;
          user-select: none;
      }

      .fa:hover {
        color: darkblue;
      }
      </style>
      </head>
      <body>
<!--
      <p>Click</p> -->
      <!-- <i onclick="myFunction(this)" class="fa fa-thumbs-up"></i>
      <script>
      function myFunction(x) {
          x.classList.toggle("fa-thumbs-down"); -->
      <!-- } -->
      </script>
      </body>
      </html>

        <!-- <?php
        //pulling data from database
        $result=mysqli_query($connection," SELECT a.username, b.Message,b.Time,b.RoomID
                            FROM users a ,message b,
                            WHERE a.userid=$usertempId");

           if($row=mysqli_fetch_array($result))
          {
            echo '<input type="text" value='.$row['Message'].'><br/>';

          }


         ?> -->
      </form>
          </div>

        </div>
      </div>
    </div>
  </div>

</div>

<footer class="container-fluid">
  <p>I-Event 2018</p>
</footer>

</body>
</html>
