<?php
 if(isset($_POST['submit'])){
 	SetCustomerSatisfaction($_POST['project_id'],$_POST['customer_satisfaction'])
 }


 function SetCustomerSatisfaction($PID,$CS){
 	$sql = "UPDATE Project SET Customer_satisfaction =:cs WHERE Project_ID =:pid";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':cs', $CS, SQLITE3_TEXT);
    $stmt->bindParam(':pid', $PID, SQLITE3_TEXT);
    $result = $stmt->execute();

 }
?>