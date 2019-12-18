<?php
ob_start();//https://stackoverflow.com/a/9709170
session_start();

// include " likes.php";

    $conn = new mysqli("localhost", "admin", "monarchs", "cs518db");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    //the SQL query to be executed
    // $query = "SELECT EXTRACT(HOUR_MINUTE  FROM `datetime`)AS Hours, DATE_FORMAT(datetime, '%W  %m %Y'  )AS mydates, 
    //           CONCAT(`fname`, ' ',`lname`) AS `Activeusers`
    //           FROM Post ";
     
    $query = "SELECT `fname`, EXTRACT(HOUR_MINUTE FROM datetime)AS Hours, CONCAT(`fname`,  (DATE_FORMAT(datetime, '%W %m %Y' ))) AS IdentTime 
              FROM Post";

    // $query = "SELECT CONCAT(`fname`, ' ',`lname`) AS `Activeusers`,EXTRACT(HOUR_MINUTE 
    // FROM `datetime`)AS mydates FROM Post 
    // ";      
    //storing the result of the executed query
    $result = $conn->query($query);
    //initialize the array to store the processed data
    $jsonArray = array();
    //check if there is any data returned by the SQL Query47
    if ($result->num_rows > 0) {
        $json = [];
        $json2= [];
        // $json3= [];
      //Converting the results into an associative array
      while($row = $result->fetch_assoc()) {
        // $jsonArrayItem = array();
        // $jsonArrayItem['label'] = $row['lname'];
        // $jsonArrayItem['value'] = $row['reaction_type_id'];
        // //append the above created object into the main array.
        // array_push($jsonArray, $jsonArrayItem);
        extract($row);
        $json2[] =  $Hours;
        $json[]= $IdentTime;
        // $json3[]= $Activeusers;

      }
    }
    //Closing the connection to DB
    $conn->close();
    //set the response content type as JSON
    // header('Content-type: application/json');
    //output the return value of json encode using the echo function.
    // echo json_encode($json);
      // echo json_encode($json3);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <p> This graph shows Time chart and utilization of each users 
         It is meant to create a visual drill down of each users activity on the site.
         A mouse hover over each point will reveal the name of user, the specific
         day, Month,year, up to the hour of the day and the Mins @ which a 
         post was made. This might be good for forenscics in case a particular 
         user initiates death treat or displays a tendency to hurt themselves.
        
     </p>
  <head>
    <title> </title>
    <a href="http://localhost/Ievent/main.php?channel=general&page=1" class="previous">&laquo; Previous</a>
</head>
<body>
    <div class= "container" style="width: 60%">
 <canvas id="myChart"></canvas>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>

 <script>

        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
    // The type of chart we want to create
        type: 'line',

    // The data for our dataset
    data: {
            labels: <?php echo json_encode($json);  ?>,

            datasets: [{
            label: "Posted@ HR:Mins",
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'Purple',
            fill : false,
            // lineTension: 1,


            data: <?php echo json_encode($json2);  ?>,
                    }]
                },

                // Configuration options go here
             options: {


        scales: {
            yAxes: [{

                ticks: {
                    beginAtZero:true

                }
                
            }]
        }
    }
});

    </script>
<a href="http://bisiade.cs518.cs.odu.edu/likes.php" class="previous">&raquo; show 'like' Analysis</a>
<a href="http://bisiade.cs518.cs.odu.edu/mostmembers_chart.php" class="previous">&raquo; next  'Channel with Most members' Analysis</a>
<a href="http://bisiade.cs518.cs.odu.edu/main.php?channel=general&page=1" class="previous">&raquo; Back to Home Page</a>

  </body>
</html>




