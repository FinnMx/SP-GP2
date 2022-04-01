<?php
/* 
Project page should display above graph:
- Project id 
- Project name
- coments regarding additional cost

Graph should display:
-value 
-Engineer cost
-Material cost
-Additional cost
-profit in Â£

graph shoukld display percentage as hover pop up.

Database should hold timescale/length of project:
- Timescale/ number of engineers on team * engineer_rate = Engineer_cost
- auto fill form Engineer_cost.

- option to display all in select box that makes all graphs viewable.

-------------------------------------------------------------------------
*/

require("require.php");
$project_id_selected = $_GET['pid'];

calculateEngineerCost($project_id_selected);


//------------------this section will set all the costs and other factors that are needed to generate the graph.------------------

$sql = "SELECT * FROM Project WHERE Project_ID=:pid AND Status = 'Active'";
$stmt = $db->prepare($sql);
$stmt->bindParam(':pid', $project_id_selected, SQLITE3_TEXT);
$result = $stmt->execute();

$arrayResult = []; //prepare an empty array first
while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
    $arrayResult[] = $row; //adding a record until end of records
}




//------------------------------------this section grabs and sets the data------------------------------------

$ProjectName = $arrayResult[0]['Project_Name'];
$ProjectVal = $arrayResult[0]['Project_value'];
$EngineerCost = $arrayResult[0]['Engineer_cost'];
$MaterialCost = $arrayResult[0]['Material_cost'];
$AdditionalCost = $arrayResult[0]['Additional_cost'];
$Timescale = $arrayResult[0]['Timescale'];
//profit calculated
$estProfit = $ProjectVal - $EngineerCost - $MaterialCost - $AdditionalCost;

//getting engineer data

$sql = "SELECT * FROM Engineer WHERE Group_ID =:gid";
$stmt = $db->prepare($sql);
$stmt->bindParam(':gid', $project_id_selected, SQLITE3_TEXT);
$result = $stmt->execute();

$EarrayResult = []; //prepare an empty array first
while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
    $EarrayResult[] = $row; //adding a record until end of records
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

    <h1 style="color:#fff; text-align:center">Project <?= $project_id_selected ?></h1>
    <br>

    <div class="row">
        <div class="col-md-2"></div>

        <!-- Project NEEDS CHANGING
        ----------------------------------------------------------------------------------------------------->
        <div class="col-md-8">
            <div class="w-box">
                <form method="post">
                    <div>
                        <h3 style="color:#0C4582; text-align:center">PROJECT DETAILS</h3>
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
                            //method to get all engineers dont know why doesnt work in the functions
                            $sql = "SELECT DISTINCT Engineer_ID, F_name, L_name, Engineer.Group_ID, Engineer_rate FROM Engineer  
                            INNER JOIN Groups
                            ON Groups.Group_ID = Engineer.Group_ID
                            INNER JOIN Project 
                            ON Groups.Project_ID = Project.Project_ID
                            WHERE Project.Project_ID = :pid"; //epic way to inner join everything

                            $stmt = $db->prepare($sql);
                            $stmt->bindParam(':pid', $project_id_selected, SQLITE3_TEXT);
                            $result = $stmt->execute(); 

                            $EFINALarrayResult = []; //prepare an empty array first
                            while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
                                $EFINALarrayResult[] = $row; //adding a record until end of records
                            }

                            for ($i = 0; $i < count($EFINALarrayResult); $i++) :
                            ?>
                              <tbody>
                                <tr>
                                  <td><?php echo $EFINALarrayResult[$i]['Engineer_ID'] ?></td>
                                  <td><?php echo $EFINALarrayResult[$i]['F_name'] ?></td>
                                  <td><?php echo $EFINALarrayResult[$i]['L_name'] ?></td>
                                  <td><?php echo $EFINALarrayResult[$i]['Group_ID'] ?></td>
                                  <td><?php echo $EFINALarrayResult[$i]['Engineer_rate'] ?></td>
                                </tr>
                              </tbody>
                            <?php endfor; ?>
                          </table>
                        </div>
                        <!-- END OF TABLE -->
                        <br>
                        <div class="form-group">
                            <input class="btn btn-main" type='submit' value="UPDATE" name='submitPM'>
                        </div>
                      
                    </div>
                </form>
            </div>
            <br>

            <!--  CHANGE GROUP needs changing
            --------------------------------------------------------------------------------------------------
            <div class="w-box">
              <h3 style="color:#0C4582; text-align:center">ADD/REMOVE GROUPS</h3>
              <br>
              <form action="manager.php" method="post">
                <div class="row" style="text-align:center">
                  <div class="col">
                    <b style="color:#0C4582">SELECT NEW GROUP</b>
                    <select class="form-group" name="group_id_selected2" id="group_id_selected">
                      <//?php
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

                      <//?php endfor; ?>
                    </select>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <input class="btn btn-main" type='submit' value="ADD" name='AddG'>
                    </div>
                    <div class="form-group">
                      <input class="btn btn-main" type='submit' value="REMOVE" name='RemoveG'>
                    </div>
                    <//?php
                    if(isset($_POST['RemoveG'])){
                      $sql = "DELETE FROM Groups WHERE Group_ID =:gid AND Project_ID =:pid";
                      $stmt = $db->prepare($sql);
                      $stmt->bindParam(':gid', $_POST['group_id_selected2'], SQLITE3_TEXT);
                      $stmt->bindParam(':pid', $project_id_selected, SQLITE3_TEXT);
                      $result = $stmt->execute();
                    }
                    if (isset($_POST['AddG'])) {
                      $sql = "INSERT INTO Groups VALUES(:gid,:pid)";
                      $stmt = $db->prepare($sql);
                      $stmt->bindParam(':gid', $_POST['group_id_selected2'], SQLITE3_TEXT);
                      $stmt->bindParam(':pid', $project_id_selected, SQLITE3_TEXT);
                      $result = $stmt->execute();
                    }

                    ?>
                  </div>
                </div>
              </form>
            </div>
        </div>
        --->

        
    </div>
    <br>
  
    <!-- GOOGLE BAR CHART fixed
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
                ['Project Name', 'Value', 'Engineer Cost', 'Material Cost', 'Additional Cost', 'est. Profit'],
                ['<?= $ProjectName ?>', <?= $ProjectVal ?>, <?= $EngineerCost ?>, <?= $MaterialCost ?>, <?= $AdditionalCost ?>, <?= $estProfit ?> ]
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
    
    <div class="row">

        <!-- Detailed Stats         
        ----------------------------------------------------------------------------------------------------->
        <div class="col-md-4">
            <div class="w-box">
                <!--Form to create projects-->
                <form action="" method="post">
                    <div>
                        <h3 style="color:#0C4582; text-align:center">DETAILED STATS</h3>
                        <br>

                        <b style="color:#0C4582">PROJECT VALUE</b>
                        <input class="form-group b-input" type="number" name="project_value" placeholder="<?= $ProjectVal ?>">
                        <br><br>

                        <b style="color:#0C4582">TIMESCALE</b>
                        <input class="form-group b-input" type="number" name="timescale" placeholder="<?= $Timescale ?>">
                        <br><br>

                        <b style="color:#0C4582">MATERIAL COST</b>
                        <input class="form-group b-input" type="number" name="material_cost" placeholder="<?= $MaterialCost ?>">
                        <br><br>

                        <b style="color:#0C4582">ADDITIONAL COST</b>
                        <input class="form-group b-input" type="number" name="additional_cost" placeholder="<?= $AdditionalCost ?>">
                        <br><br>

                        <b style="color:#0C4582">ENGINEER COST</b>
                        <input class="form-group b-input" type="number" name="engineer_cost" placeholder="<?= $EngineerCost ?>" readonly>
                        <br><br>
                    </div>
                    <br>
                    <div class="form-group">
                        <input class="btn btn-main" type='submit' value="UPDATE" name='submitDS'>
                    </div>
                    <?php

                    if(isset($_POST['submitDS'])){
                    $sql = "UPDATE Project SET Project_value =:pv, Timescale =:ts, Material_cost =:mc, Additional_cost =:ac WHERE Project_ID =:pid";
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':pid', $project_id_selected, SQLITE3_TEXT);
                    $stmt->bindParam(':pv', $ProjectVal, SQLITE3_TEXT);
                    $stmt->bindParam(':ts', $Timescale, SQLITE3_TEXT);
                    $stmt->bindParam(':mc', $MaterialCost, SQLITE3_TEXT);
                    $stmt->bindParam(':ac', $AdditionalCost, SQLITE3_TEXT);
                    $result = $stmt->execute();
                    }
                    ?>

                </form>
            </div>
        </div>

        <!-- DISPLAYING THE CHART -->
        <div class="col-md-8">
          <div class="w-box">
            <h3 style="color:#0C4582; text-align:center">CURRENT PROJECT PERFORMANCE</h3>
            <br>
            <div id="columnchart_material" style="width: 800px; height: 500px; "></div>                        
          </div>
        </div>
    </div>

  </div><!-- container -->
  <br><br>
</body>

</html>