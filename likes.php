<?php
    $conn = new mysqli("localhost", "admin", "monarchs", "cs518db");

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    //the SQL query to be executed
    $query = "SELECT CONCAT(`fname`, ' ',`lname`) AS `Activeusers`,`reaction_type_id`,COUNT(`lname`) AS 'NumberofPostsliked' 
    FROM Reaction WHERE `reaction_type_id`= 1 GROUP BY `lname` ORDER BY `reaction_type_id`ASC";


     // $query = "SELECT CONCAT(`fname`, ' ',`lname`) AS `Activeusers`,`reaction_type_id`,COUNT(`lname`) AS 'NumberofPostsliked'      FROM reaction
     //           WHERE `reaction_type_id`= 1 ";


    //storing the result of the executed query
    $result = $conn->query($query);
    //initialize the array to store the processed data
    $jsonArray = array();

    //check if there is any data returned by the SQL Query
    if ($result->num_rows > 0) {
        $json = [];
        $json2= [];
      //Converting the results into an associative array
      while($row = $result->fetch_assoc()) {
        // $jsonArrayItem = array();
        // $jsonArrayItem['label'] = $row['lname'];
        // $jsonArrayItem['value'] = $row['reaction_type_id'];
        // //append the above created object into the main array.
        // array_push($jsonArray, $jsonArrayItem);
        extract($row);
        $json[] = $Activeusers;
        $json2[]= (int)$NumberofPostsliked;

      }
    }
    //Closing the connection to DB
    $conn->close();
    //set the response content type as JSON
    // header('Content-type: application/json');
    //output the return value of json encode using the echo function.
     // echo json_encode($json);
     // echo json_encode($json2);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
   <h2> Like reaction chart for site users </h2>
  <head>
    
    <a href="http://bisiade.cs518.cs.odu.edu/chart_data.php" class="previous">&laquo; Previous</a>
</head>
<body>
    <div class= "container" style="width: 60%">
 <canvas id="myChart"></canvas>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>

 <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
    // The type of chart we want to create
        type: 'bar',

    // The data for our dataset
    data: {
            labels: <?php echo json_encode($json);  ?>,
            datasets: [{
            label: "NumberofPostsliked per User",
            backgroundColor: [
              'rgba(100,99,132,20)',
               'rgba(54, 162, 235, 1)',
               'rgba(255, 206, 86, 1)',
               'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'

            ],
            borderColor: 'black',
            borderWidth: 1,
            data: <?php echo json_encode($json2);  ?>,
                    }]
                },

                // Configuration options go here
                options: {
                      scales: {
                          yAxes: [{
                                  ticks: {
                                      beginAtZero: true
                                  }
                              }]
                      }
                  }
              });

    </script>
<a href="http://bisiade.cs518.cs.odu.edu/siteutilize_chart.php" class="previous">&raquo; Next historical info about Posts</a>
<a href="http://bisiade.cs518.cs.odu.edu/main.php?channel=general&page=1" class="previous">&raquo; Back to Home Page</a>
        
  </body>
</html>
