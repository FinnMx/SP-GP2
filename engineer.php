<?php
require("require.php");

$_SESSION['EID'];

$db = new SQLITE3('C:\xampp\htdocs\myDB.db');
$sql = "SELECT * 
        FROM Engineer 
        WHERE Engineer_ID = :EID";

$stmt = $db->prepare($sql);
$stmt->bindParam(':EID', $_SESSION['EID'], SQLITE3_TEXT);
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

<body style="color:aliceblue">
    <!-- Table displays engineers induvidual details-->
    <table class="table-dark" style="color:aliceblue">
        <?php

        for ($i = 0; $i < count($arrayResult); $i++) :

        ?>
            <table>
                <tr>
                    <th>Engineer ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Group ID</th>
                    <th>Engineer Rate PM</th>
                </tr>
              
            <tr>

                <td><?php echo $arrayResult[$i]['Engineer_ID'] ?></td>
                <td><?php echo $arrayResult[$i]['F_name'] ?></td>
                <td><?php echo $arrayResult[$i]['L_name'] ?></td>
                <td><?php echo $arrayResult[$i]['Group_ID'] ?></td>
                <td><?php echo $arrayResult[$i]['Engineer_rate'] ?></td>



            </tr>
            </table>
        <?php endfor;
        ?>


    </table>

    <!-- Table displays engineers performance details in chart/graph -->
    <table>
            <tr>
                <th>Engineer Pie Chart</th>
            </tr>
            <tr>
                
            </tr>
        



    </table>
    <?php // content="text/plain; charset=utf-8"
        require_once ('jpgraph.php');
        require_once ('jpgraph_pie.php');
        // Some data
        $data = array(40,21,17,14,23);

        // Create the Pie Graph. 
        $graph = new PieGraph(350,250);

        $theme_class="DefaultTheme";
        //$graph->SetTheme(new $theme_class());

        // Set A title for the plot
        $graph->title->Set("A Simple Pie Plot");
        $graph->SetBox(true);

        // Create
        $p1 = new PiePlot($data);
        $graph->Add($p1);

        $p1->ShowBorder();
        $p1->SetColor('black');
        $p1->SetSliceColors(array('#1E90FF','#2E8B57','#ADFF2F','#DC143C','#BA55D3'));
        $graph->Stroke();

    ?>

    <!-- Table displays engineers details compared to others-->
    <table>
    </table>




</body>

</html>