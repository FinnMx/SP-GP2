<?php
//session,header and footer
require("require.php");


$db = new SQLite3('C:\xampp\htdocs\myDB.db');
$sql = "SELECT Project_ID FROM Groups WHERE Group_ID =:gid";
$stmt = $db->prepare($sql);
$stmt->bindParam(':gid', $_SESSION['group_id_selected'], SQLITE3_TEXT);
$result = $stmt->execute();
                
$arrayResult = []; //prepare an empty array first
while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
$arrayResult[] = $row; //adding a record until end of records
}

$sql = "SELECT * FROM Project WHERE Project_ID=:pid";
$stmt = $db->prepare($sql);
$stmt->bindParam(':pid', $arrayResult[0][0], SQLITE3_TEXT);
$result = $stmt->execute();
                
$arrayResult = []; //prepare an empty array first
while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
$arrayResult[] = $row; //adding a record until end of records
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
          ['automation project 1', 100000, 44800, 27000, 1600],
          ['automation project 2', 100000, 37500, 8900, 2090]
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
                $db = new SQLite3('C:\xampp\htdocs\myDB.db');
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
            	<?php
            	if(isset($_POST['submitV']))
            	$_SESSION['group_id_selected'] = $_POST['group_id_selected'];
            	?>
            	</form> 
            </div>         

</body>
</html>