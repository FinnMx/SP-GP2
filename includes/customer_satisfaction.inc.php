<?php
<<<<<<< HEAD
=======
if (isset($_POST['submitCS'])) {
   SetCustomerSatisfaction($_POST['project_id_selected'], $_POST['customer_satisfaction']);
}

function SetCustomerSatisfaction($PID, $CS)
{
   $user_agent = getenv("HTTP_USER_AGENT");

   if (strpos($user_agent, "Win") !== FALSE)
      $os = "Windows";
   elseif (strpos($user_agent, "Mac") !== FALSE)
      $os = "Mac";
>>>>>>> 09b8b1bb69de2f9c1490d7360cf33737c0da1645

if (isset($_POST['submitCS'])) {

   $PID = $_POST['project_id'];
   $CS = $_POST['customer_satisfaction'];

   if ($PID == '' || $CS == '') {
      header("Location: ../manager.php?errorcs=emptyinput");
      exit();
   } else {
      require_once("functions.inc.php");
      SetCustomerSatisfaction($_POST['project_id'], $_POST['customer_satisfaction']);
   }
}
