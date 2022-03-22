<?php
require("require.php");

$_SESSION['PID'];

echo $_SESSION['PID'];


$sql = "SELECT *  
        FROM Project 
        WHERE Project_id = :PID";


$stmt = $db->prepare($sql);
$stmt->bindParam(':PID', $_POST['ProjectID'], SQLITE3_TEXT);
$result = $stmt->execute();

$arrayResult = []; //prepare an empty array first
while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
    $arrayResult[] = $row; //adding a record until end of records
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- Table displays Project induvidual details-->
    <table class="table-dark" style="color:aliceblue; border:white; border:3px;">
        <?php

        for ($i = 0; $i < count($arrayResult); $i++) :

        ?>
            <tr>

                <th>Project ID</th>
                <th>Project Name</th>
                <th>Project Value</th>
                <th>Engineer Cost</th>
                <th>Material Cost</th>
                <th>Additional Cost</th>
                <th>Comments</th>
                <th>Customer satisfaction</th>


                </thead>

            <tr>

                <td><?php echo $arrayResult[$i]['Project_ID'] ?></td>
                <td><?php echo $arrayResult[$i]['Project_value'] ?></td>
                <td><?php echo $arrayResult[$i]['Engineer_cost'] ?></td>
                <td><?php echo $arrayResult[$i]['Material_cost'] ?></td>
                <td><?php echo $arrayResult[$i]['Additional_cost'] ?></td>
                <td><?php echo $arrayResult[$i]['Comments'] ?></td>
                <td><?php echo $arrayResult[$i]['Customer_satisfaction'] ?></td>



            </tr>
        <?php endfor;
        ?>


    </table>

    <!-- Table displays performance of project, and displays it as a chart/graph -->
    <table class="table-dark" style="color:aliceblue; border:white">
    </table>

    <!-- Table displays projects details compared to other projects in the form of a chart/graph -->
    <table>
    </table>

    <!-- Table displays comparison of engineers in the form of a chart/graph -->
    <table class="table-dark" style="color:aliceblue; border:white">
    </table>




</body>

</html>