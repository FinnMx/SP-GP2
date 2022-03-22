<?php
require("require.php");

session_start();

$_SESSION['EID'];

$sql = "SELECT * 
        FROM Engineer 
        WHERE Engineer_ID = :EID";

$stmt = $db->prepare($sql);
$stmt->bindParam(':EID', $_SESSION['EID'], SQLITE3_TEXT);
$result = $stmt->execute();

$arrayResult = []; //prepare an empty array first
while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
  $arrayResult[] = $row; //adding a record until end of records
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {
      'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    /*function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Year', 'Sales', 'Expenses', 'Profit'],
        ['2014', 1000, 400, 200],
        ['2015', 1170, 460, 250],
        ['2016', 660, 1120, 300],
        ['2017', 1030, 540, 350]
      ]);

      var options = {
        chart: {
          title: 'Company Performance',
          subtitle: 'Sales, Expenses, and Profit: 2014-2017',
        }
      };

      var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

      chart.draw(data, google.charts.Bar.convertOptions(options));
    }*/
  </script>


</head>

<body style="color:aliceblue">
  <!-- Table displays engineers induvidual details-->
  <table class="table-dark" style="color:aliceblue; border:white; border:3px;">
    <?php

    for ($i = 0; $i < count($arrayResult); $i++) :

    ?>
      <table>
        <tr>
          <th>Engineer ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Group ID</th>
          <th>Engineer Rate PM</th>
        </tr>

        <tr>

          <td><?php echo $arrayResult[$i]['Engineer_ID'] ?></td>
          <td><?php echo $arrayResult[$i]['F_name'] ?></td>
          <td><?php echo $arrayResult[$i]['L_name'] ?></td>
          <td><?php echo $arrayResult[$i]['Group_ID'] ?></td>
          <td><?php echo $arrayResult[$i]['Engineer_rate'] ?></td>



        </tr>
      </table>
    <?php endfor;
    ?>


  </table>

  <!-- chart from google charts -->
  <div id="columnchart_material" style="width: 800px; height: 500px;"></div>



</body>

</html>