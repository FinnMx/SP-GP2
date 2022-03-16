<?php
if (isset($_POST['submit'])){
    CreateProject($_POST['project_id'], $_POST['project_value'], 0, $_POST['material_cost'], $_POST['additional_cost'], $_POST['comments'], 0);
}

function CreateProject($ProjectID, $ProjectVal, $EngineerCost, $MaterialCost, $AdditionalCost, $Comments, $CustomerSatisfaction){

	$db = new SQLite3('C:\xampp\htdocs\myDB.db');
    $sql = "INSERT INTO Project VALUES(:pid,:pval,:ecost,:mcost,:addcost,:comments,:cs)";
    $stmt = $db->prepare($sql);


    echo $ProjectID;
    $stmt->bindParam(':pid', $ProjectID, SQLITE3_TEXT);
    $stmt->bindParam(':pval', $ProjectVal, SQLITE3_TEXT);
    $stmt->bindParam(':ecost', $EngineerCost, SQLITE3_TEXT);
    $stmt->bindParam(':mcost', $MaterialCost, SQLITE3_TEXT);
    $stmt->bindParam(':addcost',$AdditionalCost, SQLITE3_TEXT);
    $stmt->bindParam(':comments', $Comments, SQLITE3_TEXT);
    $stmt->bindParam(':cs', $CustomerSatisfaction, SQLITE3_TEXT);

    $result = $stmt->execute();
}
?>