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

<body>
    <!-- Table displays engineers induvidual details-->
    <table class="table-dark">
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

            </table>

            <tr>

                <td><?php echo $arrayResult[$i]['Engineer_ID'] ?></td>
                <td><?php echo $arrayResult[$i]['F_name'] ?></td>
                <td><?php echo $arrayResult[$i]['L_name'] ?></td>
                <td><?php echo $arrayResult[$i]['group_ID'] ?></td>
                <td><?php echo $arrayResult[$i]['Engineer_rate'] ?></td>



            </tr>
        <?php endfor;
        ?>


    </table>

    <!-- Table displays engineers performance details in chart/graph -->
    <table>
        <thead>
            <td></td>
        </thead>
    </table>

    <!-- Table displays engineers details compared to others-->
    <table>
    </table>




</body>

</html>