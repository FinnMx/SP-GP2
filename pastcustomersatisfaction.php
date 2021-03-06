<?php
ob_start();
require("header.php");
require("require.php");
$project_id_selected = $_GET['pid'];

//------------------this section will set all the costs and other factors that are needed to generate the graph.------------------

$sql = "SELECT * FROM Project WHERE Status = 'Complete'";
$stmt = $db->prepare($sql);
$stmt->bindParam(':pid', $project_id_selected, SQLITE3_TEXT);
$result = $stmt->execute();

$ParrayResult = []; //prepare an empty array first
while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
    $ParrayResult[] = $row; //adding a record until end of records
}

//------------------------------------this section grabs and sets the data------------------------------------
$ProjectName = $ParrayResult[0]['Project_Name'];
$ProjectVal = $ParrayResult[0]['Project_value'];
$EngineerCost = $ParrayResult[0]['Engineer_cost'];
$MaterialCost = $ParrayResult[0]['Material_cost'];
$AdditionalCost = $ParrayResult[0]['Additional_cost'];
$Timescale = $ParrayResult[0]['Timescale'];
$customerSatisfaction = $ParrayResult[0]['Customer_satisfaction'];
//profit calculated
$estProfit = $ProjectVal - $EngineerCost - $MaterialCost - $AdditionalCost;
/*create empty array for all results
$cSArray = [];
$pNArray = [];
for ($i = 0; $i < count($ParrayResult); $i++) {
    array_push($cSArray, $ParrayResult[$i]['Customer_satisfaction']);
    array_push($pNArray, $ParrayResult[$i]['Project_name']);
}
*/

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<br>

<body>
    <div class="container">

        <h1 style="color:#fff; text-align:center">Project Satisfaction <?= $project_id_selected ?></h1>
        <br>

        <div class="row">
            <div class="row">
                <div class="col-md-2"></div>

                <div class="col-md-8">
                    <div class="w-box">

                        <form method="post">

                            <h3 style="color:#0C4582; text-align:center">PROJECT DETAILS</h3>
                            <br>



                            <!-- TABLE -->
                            <div class="b-box">
                                <table class="styled-table" style="display:block; height:140px; overflow:auto;">
                                    <thead>
                                        <tr>
                                            <th>Project Name</th>
                                            <th>Project Value</th>
                                            <th>Engineer Cost</th>
                                            <th>Material Cost</th>
                                            <th>Additional Cost</th>
                                            <th>Timescale</th>
                                        </tr>
                                    </thead>


                                        <tbody>
                                            <tr>
                                                <td><?php echo $ProjectName ?></td>
                                                <td><?php echo $ProjectVal ?></td>
                                                <td><?php echo $EngineerCost ?></td>
                                                <td><?php echo $MaterialCost ?></td>
                                                <td><?php echo $AdditionalCost ?></td>
                                                <td><?php echo $Timescale ?></td>
                                            </tr>
                                        </tbody>

                                </table>
                            </div>


                        </form>
                    </div>
                    <br>
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
                            ['Project Name', 'Final Value', 'Engineer Cost', 'Material Cost', 'Additional Cost', 'Estimated Profit'],
                            <?php
                            for ($j = 0; $j < count($ParrayResult); $j++) {
                                $Xarray = array($ProjectName, $ProjectVal, $EngineerCost, $MaterialCost, $AdditionalCost, $estProfit);
                                echo json_encode($Xarray);
                                echo ",";
                            }
                            ?>
                        ]);

                        var options = {
                            chart: {
                                title: 'Completed projects',
                                subtitle: 'Showing all the Satisfaction rates for each project',
                            }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                </script>

                <div class="row">



                    <!-- DISPLAYING THE CHART -->
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="w-box">
                            <h3 style="color:#0C4582; text-align:center">FINAL PROJECT STATS (CS RATING: <?= $customerSatisfaction ?>)</h3>
                            <br>
                            <div id="columnchart_material" style="width: 800px; height: 500px; "></div>
                        </div>
                    </div>
                </div>

            </div><!-- container -->
            <br><br>
</body>

</html>