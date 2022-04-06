<?php
ob_start();
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
$ProjectName = $arrayResult[0]['Project_name'];
$ProjectVal = $arrayResult[0]['Project_value'];
$EngineerCost = $arrayResult[0]['Engineer_cost'];
$MaterialCost = $arrayResult[0]['Material_cost'];
$AdditionalCost = $arrayResult[0]['Additional_cost'];
$Timescale = $arrayResult[0]['Timescale'];
$customerSatisfaction = $arrayResult[0]['Customer_satisfaction'];
//profit calculated
$estProfit = $ProjectVal - $EngineerCost - $MaterialCost - $AdditionalCost;
//create empty array for all results
$cSArray = [];
$pNArray = [];
for ($i = 0; $i < count($arrayResult); $i++) {
    array_push($cSArray, $arrayResult[$i]['Customer_satisfaction']);
    array_push($pNArray, $arrayResult[$i]['Project_name']);
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

        <h1 style="color:#fff; text-align:center">Project Satisfaction <?= $project_id_selected ?></h1>
        <br>

        <div class="row">
            <div class="row">

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
                                    <?php for ($i = 0; $i < count($arrayResult); $i++) : ?>


                                        <tbody>
                                            <tr>
                                                <td><?php echo $arrayResult[$i]['Project_name'] ?></td>
                                                <td><?php echo $arrayResult[$i]['Project_value'] ?></td>
                                                <td><?php echo $arrayResult[$i]['Engineer_cost'] ?></td>
                                                <td><?php echo $arrayResult[$i]['Material_cost'] ?></td>
                                                <td><?php echo $arrayResult[$i]['Additional_cost'] ?></td>
                                                <td><?php echo $arrayResult[$i]['Timescale'] ?></td>
                                            </tr>
                                        </tbody>
                                    <?php
                                    endfor;
                                    ?>

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
                            ['Project Name', 'customer_satisfaction'],
                            <?php
                            for ($j = 0; $j < count($ParrayResult); $j++) {
                                $Xarray = array($pNArray[$j], $cSArray[$j]);
                                echo json_encode($xArray);
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

                <div class="row">



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