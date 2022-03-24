<?php

/* 
Group page should display above graph:
displays all projects related to that group.

-------------------------------------------------------------------------
*/

//session,header and footer
require("require.php");

session_start();

$_SESSION['group_id_selected'] = $_POST['group_id_selected'];
$sql = "SELECT Project_ID FROM Groups WHERE Group_ID =:gid";
$stmt = $db->prepare($sql);
$stmt->bindParam(':gid', $_SESSION['group_id_selected'], SQLITE3_TEXT);
$result = $stmt->execute();

$GarrayResult = []; //prepare an empty array first
while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
  $GarrayResult[] = $row; //adding a record until end of records
}

$Values = array();

for ($i = 0; $i < count($GarrayResult); $i++) {
  $sql = "SELECT * FROM Project WHERE Project_ID=:pid AND Status = 'Active'";
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':pid', $GarrayResult[$i][0], SQLITE3_TEXT);
  $result = $stmt->execute();


  $arrayResult = []; //prepare an empty array first
  while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
    $arrayResult[] = $row; //adding a record until end of records
  }
  array_push($Values, $arrayResult);
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {
      'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawChart);



    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Project Name', 'Value', 'Engineer Cost', 'Material Cost', 'Additional Cost'],
        
        <?php 
        for ($i = 0; $i < count($GarrayResult); $i++){
          $xarray = array($Values[$i][0]['Project_Name'],$Values[$i][0]['Project_value'], $Values[$i][0]['Engineer_cost'], $Values[$i][0]['Material_cost'], $Values[$i][0]['Additional_cost']);
          echo json_encode($xarray);
          echo ",";
        }
        ?>
      

      ]);

      var options = {
        chart: {
          title: 'Group Projects',
          subtitle: 'Displaying all projects that are being managed by the group',
        }
      };

      var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

      chart.draw(data, google.charts.Bar.convertOptions(options));
    }
  </script>

</head>

<body>

  <!-- chart from google charts -->
  <div id="columnchart_material" style="width: 800px; height: 500px; position: absolute; top: 6%;"></div>

  <div class="w-box" style="width: 250px; position: inherit;">
    <form action="ViewGroups.php" method="post">
      <select class="form-group col-md-4" name="group_id_selected" id="group_id_selected">
        <?php
        $sql = "SELECT Group_ID FROM Groups";
        $stmt = $db->prepare($sql);
        $result = $stmt->execute();

        $arrayResult = []; //prepare an empty array first
        while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
          $arrayResult[] = $row; //adding a record until end of records
        }

        for ($i = 0; $i < count($arrayResult); $i++) :
          $value = $arrayResult[$i]['Group_ID'];
          echo '<option value="' . $value . '">' . $value . '</option>';
        ?>

        <?php endfor; ?>
      </select>
      <div class="form-group col-md-4">
        <input class="btn btn-primary" type='submit' value="View" name='submitV'>
      </div>
    </form>
  </div>


  <table style="border-collapse: collapse; margin: 25px 0; font-size: 0.9em; min-width: 400px; margin-left: auto; margin-right: auto;">
    <thead style="background-color: #d3e239; color: #fff; text-align: left;">
      <tr>
        <th>Engineer ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Group ID</th>
        <th>Engineer Rate PM</th>
      </tr>
    </thead>
    <?php
    //getting engineer data
    $sql = "SELECT * FROM Engineer WHERE Group_ID =:gid";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':gid', $_SESSION['group_id_selected'], SQLITE3_TEXT);
    $result = $stmt->execute();

    $EarrayResult = []; //prepare an empty array first
    while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
      $EarrayResult[] = $row; //adding a record until end of records
    }

    for ($i = 0; $i < count($EarrayResult); $i++) :
    ?>
      <tbody style="background-color:#fff; color:#000; text-align:left">
        <tr>
          <td><?php echo $EarrayResult[$i]['Engineer_ID'] ?></td>
          <td><?php echo $EarrayResult[$i]['F_name'] ?></td>
          <td><?php echo $EarrayResult[$i]['L_name'] ?></td>
          <td><?php echo $EarrayResult[$i]['Group_ID'] ?></td>
          <td><?php echo $EarrayResult[$i]['Engineer_rate'] ?></td>
        </tr>
      </tbody>
    <?php endfor; ?>
  </table>



  </table>

</body>

</html>