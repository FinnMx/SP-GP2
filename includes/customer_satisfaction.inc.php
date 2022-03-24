<?php
if (isset($_POST['submitCS'])) {
   SetCustomerSatisfaction($_POST['project_id'], $_POST['customer_satisfaction']);
}


function SetCustomerSatisfaction($PID, $CS)
{
   $user_agent = getenv("HTTP_USER_AGENT");

   if (strpos($user_agent, "Win") !== FALSE)
      $os = "Windows";
   elseif (strpos($user_agent, "Mac") !== FALSE)
      $os = "Mac";

   if ($os === "Windows") {
      $db = new SQLite3('C:\xampp\htdocs\myDB.db');
   } elseif ($os === "Mac") {
      $db = new SQLite3('/Applications/XAMPP/data/myDB.db');
   };

   $status = "complete";

   $sql = "UPDATE Project SET Customer_satisfaction =:cs AND Status =:status WHERE Project_ID =:pid";
   $stmt = $db->prepare($sql);
   $stmt->bindParam(':cs', $CS, SQLITE3_TEXT);
   $stmt->bindParam(':status', $status, SQLITE3_TEXT);
   $stmt->bindParam(':pid', $PID, SQLITE3_TEXT);
   $result = $stmt->execute();


   header("Location: ../manager.php");
}
