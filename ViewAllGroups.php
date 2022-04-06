<?php

/* 
Group page should display above graph:
displays all projects related to that group.

-------------------------------------------------------------------------

This whole block of php practically just pulls all the projects that the selected 
group is managing, it then stores all of this in an multidimentional array and
then converts it into a json JavaScript format. Once its been converted to a JS array 
a for loop is then started in-line php to echo out and generate the graphs from the 
array.
*/

//session,header and footer
require("header.php");
require("require.php");

//session_start();
ob_start();
//------------------Selects all groups to start the loop-----------
$sql = "SELECT DISTINCT Group_ID FROM Groups";
$stmt = $db->prepare($sql);
$result = $stmt->execute(); 

$AGarrayResult = []; //prepare an empty array first
while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
  $AGarrayResult[] = $row; //adding a record until end of records
}

//vars
$Values = array();
$GidS = array();
$ProjVals = array();
$EngCost = array();
$MatCost = array();
$AddCost = array();

for($j = 0; $j < count($AGarrayResult); $j++){
    //---------------------Selects projects----------------------------
    $sql = "SELECT DISTINCT Project_ID FROM Groups WHERE Group_ID =:gid AND Project_ID != 0";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':gid', $AGarrayResult[$j][0], SQLITE3_TEXT);
    $result = $stmt->execute(); 

    $GarrayResult = []; //prepare an empty array first
    while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
      $GarrayResult[] = $row; //adding a record until end of records
    }

    //---------------------Retrieves project data-----------------------
    $currentVal = 0;
    $currentEng = 0;
    $currentMat = 0;
    $currentAdd = 0;
    for ($i = 0; $i < count($GarrayResult); $i++) {
      $sql = "SELECT Project_value, Engineer_cost, Material_cost, Additional_cost FROM Project WHERE Project_ID=:pid AND Status = 'Active'"; 
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':pid', $GarrayResult[$i][0], SQLITE3_TEXT); //sets the current projectID based on the counter $i.
      $result = $stmt->execute();


      $arrayResult = []; //prepare an empty array first
      while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
        $arrayResult[] = $row; //adding a record until end of records
      }

      $currentVal += $arrayResult[0]['Project_value'];
      $currentEng += $arrayResult[0]['Engineer_cost'];
      $currentMat += $arrayResult[0]['Material_cost'];
      $currentAdd += $arrayResult[0]['Additional_cost'];
    }
    array_push($ProjVals, $currentVal);
    array_push($EngCost, $currentEng);
    array_push($MatCost, $currentEng);
    array_push($AddCost, $currentEng);
}

array_filter($Values); //simple way to remove the values that are null due to the status of the project being closed.

//echo count($Values);

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

    <h1 style="color:#fff; text-align:center">GROUP <?php echo $group_id_selected ?></h1>
    <br>

    <div class="row">
        <div class="col-md-2"></div>

        <!-- GROUP DETAILS
        ----------------------------------------------------------------------------------------------------->
        <div class="col-md-8">
            <div class="w-box">
                <form method="post">
                    <div>
                        <h3 style="color:#0C4582; text-align:center">GROUP DETAILS</h3>
                        <br>
                        <b style="color:#0C4582">DESCRIPTION</b>
                        <input class="form-group b-input" type="text" name="first_name" placeholder="First name">
                        <br><br>

                        <b style="color:#0C4582">TEAM MEMBERS:</b>
                        <!-- TABLE -->
                        <div class="b-box">
                          <table class="styled-table" style="display:block; height:200px; overflow:auto;">
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
                            $sql = "SELECT * FROM Engineer WHERE Group_ID =:gid AND Status = 'active'";
                            $stmt = $db->prepare($sql);
                            $stmt->bindParam(':gid', $group_id_selected, SQLITE3_TEXT);
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
                        <br>
                        <div class="form-group">
                            <input class="btn btn-main" type='submit' value="UPDATE" name='submitE'>
                        </div>
                      
                    </div>
                </form>
            </div>
            <br>
        </div>
    </div>



        
  
    <!-- GOOGLE BAR CHART
    ----------------------------------------------------------------------------------------------------->
    <!-- SCRIPT FOR CHART -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {
        'packages': ['bar']
      });
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Group ID', 'Total Value', 'Total Managed Cost', 'Total Engineer Cost', 'Total Material Cost', 'Total Additional Cost'],
          
          <?php 
          for ($i = 0; $i < count($AGarrayResult); $i++){
            $TotalCost = $EngCost[$i] + $MatCost[$i] + $AddCost[$i];
            $xarray = array("Group ".$AGarrayResult[$i][0], $ProjVals[$i], $TotalCost, $EngCost[$i], $MatCost[$i], $AddCost[$i]);
            echo json_encode($xarray);
            echo ",";
          }
          ?>
        ]);

        var options = {
          chart: {
            title: 'Aggregate Group Data',
            subtitle: 'Displaying Each Groups Total Costs And Estimated Values',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
    
    <!-- DISPLAYING THE CHART -->
    <div class="row">
        <div class="col-md-2"></div>

        <div class="col-md-8">
          <div class="w-box">
            <h3 style="color:#0C4582; text-align:center">CURRENT GROUP PERFORMANCE</h3>
            <br>
            <div id="columnchart_material" style="width: 800px; height: 500px; "></div>                        
          </div>
        </div>
    </div>

  </div><!-- container -->
  <br><br>
</body>

</html>