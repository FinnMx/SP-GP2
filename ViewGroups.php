<?php
//session,header and footer
require("require.php");

session_start();

$_SESSION['group_id_selected'] = $_POST['group_id_selected'];
$sql = "SELECT Project_ID FROM Groups WHERE Group_ID =:gid";
$stmt = $db->prepare($sql);
$stmt->bindParam(':gid', $_SESSION['group_id_selected'], SQLITE3_TEXT);
$result = $stmt->execute();
                
$arrayResult = []; //prepare an empty array first
while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
$arrayResult[] = $row; //adding a record until end of records
}

$sql = "SELECT * FROM Project WHERE Project_ID=:pid AND Status = 'Active'";
$stmt = $db->prepare($sql);
$stmt->bindParam(':pid', $arrayResult[0][0], SQLITE3_TEXT);
$result = $stmt->execute();
                
$arrayResult = []; //prepare an empty array first
while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
$arrayResult[] = $row; //adding a record until end of records
}

$ProjectName = $arrayResult[0]['Project_Name'];
$ProjectVal = $arrayResult[0]['Project_value'];
$EngineerCost = $arrayResult[0]['Engineer_cost'];
$MaterialCost = $arrayResult[0]['Material_cost'];
$AdditionalCost = $arrayResult[0]['Additional_cost'];

//getting engineer data

$sql = "SELECT * FROM Engineer WHERE Group_ID =:gid";
$stmt = $db->prepare($sql);
$stmt->bindParam(':gid', $_SESSION['group_id_selected'], SQLITE3_TEXT);
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

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);



      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Project Name', 'Value', 'Engineer Cost', 'Material Cost', 'Additional Cost'],
          ['<?=$ProjectName?>', <?=$ProjectVal?>, <?=$EngineerCost?>, <?=$MaterialCost?>, <?=$AdditionalCost?>]
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
                    echo '<option value="'.$value.'">'.$value.'</option>';                
                ?>

                <?php endfor;?>
                </select>  
               	<div class="form-group col-md-4">
                <input class="btn btn-primary" type='submit' value="View" name='submitV'>
            	</div>
            	</form> 
            </div> 

                <table class="table-dark" style="color:aliceblue; border:white; border:3px; position: absolute; left: 43.5%;">

        <?php
        for ($i = 0; $i < count($EarrayResult); $i++) :
        ?>
                <tr>
                    <th>Engineer ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Group ID</th>
                    <th>Engineer Rate PM</th>
                </tr>
                <tr>
                    <td><?php echo $EarrayResult[$i]['Engineer_ID'] ?></td>
                    <td><?php echo $EarrayResult[$i]['F_name'] ?></td>
                    <td><?php echo $EarrayResult[$i]['L_name'] ?></td>
                    <td><?php echo $EarrayResult[$i]['Group_ID'] ?></td>
                    <td><?php echo $EarrayResult[$i]['Engineer_rate'] ?></td>
                </tr>
            </table>
        <?php endfor;
        ?>


    </table>        

</body>
</html>