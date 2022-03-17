<?php
require("require.php");

$_SESSION['PID'];

echo $_SESSION['PID'];


$db = new SQLITE3('C:\xampp\htdocs\myDB.db');
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
    <table>
        <?php

        for ($i = 0; $i < count($arrayResult); $i++) :

        ?>
            <thead>

                <td>Project ID</td>
                <td>Project Name</td>
                <td>Project Value</td>
                <td>Engineer Cost</td>
                <td>Material Cost</td>
                <td>Additional Cost</td>
                <td>Comments</td>
                <td>Customer satisfaction</td>


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
    <table>
    </table>

    <!-- Table displays projects details compared to other projects in the form of a chart/graph -->
    <table>
    </table>

     <!-- Table displays comparison of engineers in the form of a chart/graph -->
     <table>
    </table>




</body>

</html>