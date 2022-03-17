<?php
require("require.php");

$_SESSION['EID'];

echo $_SESSION['EID'];

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
    <table>
        <?php

        for ($i = 0; $i < count($arrayResult); $i++) :

        ?>
            <thead>

            <td>Engineer ID</td>
            <td>First Name</td>
            <td>Last Name</td>
            <td>Group ID</td>
            <td>Engineer Rate PM</td>


            </thead>

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
    </table>

    <!-- Table displays engineers details compared to others-->
    <table>
    </table>




</body>

</html>