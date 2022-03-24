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
</head>

<br>

<body>
  <div class="container">  

    <h1 style="color:#fff; text-align:center">GROUP </h1>
    <br>

    <div class="row">
        <div class="col-md-2"></div>

        <!-- GROUP DETAILS
        ----------------------------------------------------------------------------------------------------->
        <div class="col-md-4">
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
                          <table class="styled-table" style="display:block; height:140px; overflow:auto;">
                            <thead >
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

            <!-- CHANGE GROUP
            ----------------------------------------------------------------------------------------------------->
            <div class="w-box">
              <h3 style="color:#0C4582; text-align:center">CHANGE GROUP</h3>
              <br>
              <form action="ViewGroups.php" method="post">
                <div class="row" style="text-align:center">
                  <div class="col">
                    <b style="color:#0C4582">SELECT NEW GROUP</b>
                    <select class="form-group" name="group_id_selected" id="group_id_selected">
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

        <!-- INPUT PERFORMANCE         
        ----------------------------------------------------------------------------------------------------->
        <div class="col-md-4">
            <div class="w-box">
                <!--Form to create projects-->
                <form action="includes/create_project.inc.php" method="post">
                    <div>
                        <h3 style="color:#0C4582; text-align:center">INPUT PERFORMANCE</h3>
                        <br>

                        <b style="color:#0C4582">PROJECT VALUE</b>
                        <input class="form-group b-input" type="number" name="project_value" placeholder="Project Value" min="1">
                        <br><br>

                        <b style="color:#0C4582">TIMESCALE</b>
                        <input class="form-group b-input" type="number" name="timescale" placeholder="Timescale" min="1">
                        <br><br>

                        <b style="color:#0C4582">MATERIAL COST</b>
                        <input class="form-group b-input" type="number" name="material_cost" placeholder="Material cost" min="1">
                        <br><br>

                        <b style="color:#0C4582">ADDITIONAL COST</b>
                        <input class="form-group b-input" type="number" name="additional_cost" placeholder="Additional cost" min="1">
                        <br><br>

                        <b style="color:#0C4582">COMMENTS</b>
                        <input class="form-control b-input" type="text" name="comments" placeholder="Comments on cost and job specifics">
                        <br>
                    </div>
                    <br>
                    <div class="form-group">
                        <input class="btn btn-main" type='submit' value="SUBMIT" name='submitCP'>
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