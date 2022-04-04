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

//---------------------Selects projects----------------------------
$group_id_selected = $_GET['gid'];
$sql = "SELECT Project_ID FROM Groups WHERE Group_ID =:gid AND Project_ID != 0";
$stmt = $db->prepare($sql);
$stmt->bindParam(':gid', $group_id_selected, SQLITE3_TEXT);
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

array_filter($Values); //simple way to remove the values that are null due to the status of the project being closed.

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

    <div class="row">
        <div class="col-md-2"></div>

        <div class="col-md-4">
            <!-- CHANGE GROUP
            ----------------------------------------------------------------------------------------------------->
            <div class="w-box">
              <h3 style="color:#0C4582; text-align:center">CHANGE GROUP</h3>
              <br>
              <form action="manager.php" method="post">
                <div class="row" style="text-align:center">
                  <div class="col">
                    <b style="color:#0C4582">SELECT NEW GROUP</b>
                    <select class="form-group" name="group_id_selected" id="group_id_selected">
                      <?php
                      $sql = "SELECT DISTINCT Group_ID FROM Groups";
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
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <input class="btn btn-main" type='submit' value="CHANGE" name='submitV'>
                    </div>
                  </div>
                </div>
              </form>
            </div>
        </div>


        <!-- Remove engineers/Add engineers         
        ----------------------------------------------------------------------------------------------------->
        <div class="col-md-4">
            <div class="w-box">
                <!--Form to create projects-->
                <form method="post">
                    <div>
                        <h3 style="color:#0C4582; text-align:center">REMOVE/ADD ENGINEERS</h3>
                        <br>
                        <b style="color:#0C4582">CURRENT ENGINEERS</b>
                        <br>
                        <select class="form-group" name="current_engineers" id="current_engineers">
                        <?php
                        $sql = "SELECT Engineer_ID FROM Engineer WHERE Group_ID =:gid AND Status = 'active'";
                        $stmt = $db->prepare($sql);
                        $stmt->bindParam(':gid', $group_id_selected, SQLITE3_TEXT);
                        $result = $stmt->execute();

                        $arrayResult = []; //prepare an empty array first
                        while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
                          $arrayResult[] = $row; //adding a record until end of records
                        }

                        for ($i = 0; $i < count($arrayResult); $i++) :
                          $value = $arrayResult[$i]['Engineer_ID'];
                          echo '<option value="' . $value . '">' . $value . '</option>';
                        ?>

                        <?php endfor; ?>
                        </select>
                        <input class="btn btn-main" type='submit' value="REMOVE" name='removeE'>
                        <?php
                        if(isset($_POST['removeE'])){
                          $sql = "UPDATE Engineer SET Status = 'inactive' WHERE Engineer_ID =:eid";
                          $stmt = $db->prepare($sql);
                          $stmt->bindParam(':eid', $_POST['current_engineers'], SQLITE3_TEXT);
                          $result = $stmt->execute();
                          
                          header("Location: ViewGroups.php?gid=". $group_id_selected);
                          ob_end_flush();
                        }
                        ?>

                        <br><br>

                        <b style="color:#0C4582">UNASSIGNED ENGINEERS</b>
                        <br>
                        <select class="form-group" name="unassigned_engineers" id="unassigned_engineers">
                        <?php
                        $sql = "SELECT Engineer_ID FROM Engineer WHERE Status = 'inactive'";
                        $stmt = $db->prepare($sql);
                        $result = $stmt->execute();

                        $arrayResult = []; //prepare an empty array first
                        while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
                          $arrayResult[] = $row; //adding a record until end of records
                        }

                        for ($i = 0; $i < count($arrayResult); $i++) :
                          $value = $arrayResult[$i]['Engineer_ID'];
                          echo '<option value="' . $value . '">' . $value . '</option>';
                        ?>

                        <?php endfor; ?>
                        </select>
                        <input class="btn btn-main" type='submit' value="ADD" name='addE'>
                        <?php
                        if(isset($_POST['addE'])){
                          $sql = "UPDATE Engineer SET Status = 'active', Group_ID =:gid WHERE Engineer_ID =:eid";
                          $stmt = $db->prepare($sql);
                          $stmt->bindParam(':gid', $group_id_selected, SQLITE3_TEXT);
                          $stmt->bindParam(':eid', $_POST['unassigned_engineers'], SQLITE3_TEXT);
                          $result = $stmt->execute();

                          header("Location: ViewGroups.php?gid=". $group_id_selected);
                          ob_end_flush();
                        }
                        ?>
                        <br><br>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <br>
  
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