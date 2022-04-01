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

//---------------------Selects projects----------------------------
$_SESSION['group_id_selected'] = $_POST['group_id_selected']; 
$sql = "SELECT Project_ID FROM Groups WHERE Group_ID =:gid";
$stmt = $db->prepare($sql);
$stmt->bindParam(':gid', $_SESSION['group_id_selected'], SQLITE3_TEXT);
$result = $stmt->execute(); 

$GarrayResult = []; //prepare an empty array first
while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
  $GarrayResult[] = $row; //adding a record until end of records
}

//---------------------Retrieves project data-----------------------
$Values = array();

for ($i = 0; $i < count($GarrayResult); $i++) {
  $sql = "SELECT * FROM Project WHERE Project_ID=:pid AND Status = 'Active'"; 
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':pid', $GarrayResult[$i][0], SQLITE3_TEXT); //sets the current projectID based on the counter $i.
  $result = $stmt->execute();


  $arrayResult = []; //prepare an empty array first
  while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
    $arrayResult[] = $row; //adding a record until end of records
  }
//---------------------Pushes each data into big arary---------------
  array_push($Values, $arrayResult);
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
</head>

<br>

<body>
  <div class="container">  

    <h1 style="color:#fff; text-align:center">WELCOME "ENGINEER NAME"</h1>
    <br>

    <div class="row">
      <div class="col-md-1"></div>

      <!-- GROUP DETAILS
      ----------------------------------------------------------------------------------------------------->
      <div class="col-md-10">
      <div class="w-box">

        <div class="row">

          <div class="col-md-6">
            <h3 style="color:#0C4582; text-align:center">TABLE</h3>
            <br>
            <!-- TABLE -->
            <div class="b-box">
              <table class="styled-table" style="display:block; height:140px; overflow:auto;">
                <thead >
                  <tr>
                    <th>ID</th>
                    <th>FIRST NAME</th>
                    <th>LAST NAME</th>
                    <th>GROUP ID</th>
                    <th>PAY RATE P/M</th>
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
                  <tbody>
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
            </div>
            <!-- END OF TABLE -->    
          </div>

          <!-- GOOGLE BAR CHART
          ----------------------------------------------------------------------------------------------------->
          <div class="col-md-6" style="text-align:center">
            <h3 style="color:#0C4582; text-align:center">CHART</h3>
            <br>
            <!-- SCRIPT FOR CHART -->
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
            
            <!-- DISPLAYING THE CHART -->
            <div id="columnchart_material" style="width: 500px; height: 300px; "></div>
          </div>
  
        </div><!-- end of row -->
      </div>
      </div>
  </div><!-- container -->
  <br><br>
</body>

</html>