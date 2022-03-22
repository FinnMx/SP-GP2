<?php
 if(isset($_POST['submitCS'])){
 	SetCustomerSatisfaction($_POST['project_id'],$_POST['customer_satisfaction']);
 }


 function SetCustomerSatisfaction($PID,$CS){
 	$db = new SQLite3('C:\xampp\htdocs\myDB.db');
 	$sql = "UPDATE Project SET Customer_satisfaction =:cs WHERE Project_ID =:pid";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':cs', $CS, SQLITE3_TEXT);
    $stmt->bindParam(':pid', $PID, SQLITE3_TEXT);
    $result = $stmt->execute();


    header("Location: ..\Manager.php");
 }
?>