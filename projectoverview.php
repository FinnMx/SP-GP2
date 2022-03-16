<?php
require("require.php");

$db = new SQLITE3('mydb.db');
$sql = "SELECT * 
        FROM Project 
        WHERE Project_id = 1";


$stmt = $db->prepare($sql);
$result = $stmt->execute();

$arrayResult = []; //prepare an empty array first
while ($row = $result->fetchArray()) { // use fetchArray(SQLITE3_NUM) - another approach
    $arrayResult[] = $row; //adding a record until end of records
}

