<?php
    $conn = new mysqli("localhost", "admin", "monarchs", "cs518db");

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    //the SQL query to be executed
    $query = "SELECT  `Channel`.`name` AS GROUPNAME,COUNT(`Channel_Membership`.`channel_id`) AS Topchannel 
              FROM `Channel` , `Channel_Membership`
              WHERE `Channel`.`channel_id` = `Channel_Membership`.`channel_id`
              GROUP BY `Channel`.`name` ";


     // $query = "SELECT CONCAT(`fname`, ' ',`lname`) AS `Activeusers`,`reaction_type_id`,COUNT(`lname`) AS 'NumberofPostsliked'      FROM reaction
     //           WHERE `reaction_type_id`= 1 ";


    //storing the result of the executed query
    $result = $conn->query($query);
    //initialize the array to store the processed data


    //check if there is any data returned by the SQL Query
    if ($result->num_rows > 0) {
        $json = [];
        $json2= [];
      //Converting the results into an associative array
      while($row = $result->fetch_assoc()) {
//        echo "id: " . $row["GROUPNAME"]. " - Topchannel: " . $row["Topchannel"]. "<br>" ;
        extract($row);
        $jsonxxx[] = ($GROUPNAME);
        $json[] = $row['GROUPNAME'];
        $json2[]= $row['Topchannel'] ;

      }
    }

//       echo json_encode($json);
//       echo json_encode($json2);

    //Closing the connection to DB
    $conn->close();
  
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>

  <head>
  <p> Chart showing the channels with the most registered users </p>
    <a href="http://bisiade.cs518.cs.odu.edu/chart_data.php" class="previous">&laquo; Previous</a>
</head>
<body>
    <div class= "container" style="width: 60%">
 <canvas id="myChart"></canvas>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js">
 <script type="text/javascript" src="chartjs-plugin-colorschemes.js">  
 </script>


 <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
    // The type of chart we want to create
        type: 'horizontalBar',

    // The data for our dataset
    data: {
            labels: <?php echo json_encode($json);  ?>,
            datasets: [{
            label: "Channel group with most members",
            backgroundColor: [
              'rgba(150,99,132,20)',
               'rgba(150,99,132,20)',
               'rgba(150,99,132,20)',
               'rgba(150,99,132,20)',
                'rgba(150,99,132,20)',
                'rgba(150,99,132,20)'

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
<a href="http://bisiade.cs518.cs.odu.edu/main.php?channel=general&page=1" class="previous">&raquo; Back to Home Page</a>
  </body>
</html>
