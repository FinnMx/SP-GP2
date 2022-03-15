<?php
require("require.php");

$db = new SQLITE3('/Applications/XAMPP/data/.db');
$sql = "SELECT * 
        FROM Project 
        WHERE Project_id = 1 
        AND News_id = 1";


$stmt = $db->prepare($sql);
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


    <div>
        <thead class="table-dark">

            <td><?php echo $arrayResult[$i]['Title'] ?></td>

        </thead>

        <tr>

            <td style=color:aliceblue><?php echo $arrayResult[$i]['Body'] ?></td>
            <td style=color:aliceblue><img src="<?php echo $arrayResult[$i]['Image_reference'] ?>" alt=""></td>


        </tr>
    </div>

    <div>
        <thead class="table-dark">

            <td><?php echo $arrayResult[$i]['Title'] ?></td>

        </thead>

        <tr>

            <td style=color:aliceblue><?php echo $arrayResult[$i]['Body'] ?></td>
            <td style=color:aliceblue><img src="<?php echo $arrayResult[$i]['Image_reference'] ?>" alt=""></td>


        </tr>

    </div>


</body>

</html>