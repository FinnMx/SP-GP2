<?php
if (isset($_POST['submitCP'])){
    CreateProject($_POST['project_id'], $_POST['project_name'], $_POST['project_value'], $_POST['engineer_cost'], $_POST['material_cost'], $_POST['additional_cost'], $_POST['comments'], 0, "Active",$_POST['Timescale']);
}

function CreateProject($ProjectID, $ProjectName, $ProjectVal, $EngineerCost, $MaterialCost, $AdditionalCost, $Comments, $CustomerSatisfaction, $Status, $Timescale){


    $user_agent = getenv("HTTP_USER_AGENT");

    if(strpos($user_agent, "Win") !== FALSE)
    $os = "Windows";
    elseif(strpos($user_agent, "Mac") !== FALSE)
    $os = "Mac";

    if($os === "Windows")
    {
        $db = new SQLite3('C:\xampp\htdocs\myDB.db');
    }
    elseif($os === "Mac")
    {
        $db = new SQLite3('/Applications/XAMPP/data/myDB.db');
    } 
    ;
    
    $sql = "INSERT INTO Project VALUES(:pid,:pname,:pval,:ecost,:mcost,:addcost,:comments,:cs,:status,:ts)";
    $stmt = $db->prepare($sql);


    echo $ProjectID;
    $stmt->bindParam(':pid', $ProjectID, SQLITE3_TEXT);
    $stmt->bindParam(':pname', $ProjectName, SQLITE3_TEXT);
    $stmt->bindParam(':pval', $ProjectVal, SQLITE3_TEXT);
    $stmt->bindParam(':ecost', $EngineerCost, SQLITE3_TEXT);
    $stmt->bindParam(':mcost', $MaterialCost, SQLITE3_TEXT);
    $stmt->bindParam(':addcost',$AdditionalCost, SQLITE3_TEXT);
    $stmt->bindParam(':comments', $Comments, SQLITE3_TEXT);
    $stmt->bindParam(':cs', $CustomerSatisfaction, SQLITE3_TEXT);
    $stmt->bindParam(':status', $Status, SQLITE3_TEXT);
    $stmt->bindParam(':ts', $Timescale, SQLITE3_TEXT);

    $result = $stmt->execute();

    header("Location: ../manager.php");
}
